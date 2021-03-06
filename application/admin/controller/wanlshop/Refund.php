<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
use Exception;
/**
 * 订单退款管理
 *
 * @icon fa fa-circle-o
 */
class Refund extends Backend
{
    
    /**
     * Refund模型对象
     * @var \app\admin\model\wanlshop\Refund
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Refund;
        $this->view->assign("expresstypeList", $this->model->getExpresstypeList());
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("reasonList", $this->model->getReasonList());
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 查看
     */
    public function index()
    {
        //當前是否为关联查詢
        $this->relationSearch = true;
        //设置过濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果发送的來源是Selectpage，則轉发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','order','pay','shop','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['user','order','pay','shop','goods'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {

				$row->getRelation('goods')->visible(['title','image']);
                $row->getRelation('user')->visible(['id']);
                $row->getRelation('order')->visible(['id']);
				$row->getRelation('pay')->visible(['pay_no']);
				$row->getRelation('shop')->visible(['shopname']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

	

	/**

	 * 退款详情

	 */

	public function detail($ids = null)

	{

	    $row = $this->model->get($ids);

	    if (!$row) {

	        $this->error(__('No Results were found'));

	    }

		$row['images'] = explode(',', $row['images']);

		$row['ordergoods'] = model('app\admin\model\wanlshop\OrderGoods')

			->where('id', 'in', $row['goods_ids'])

			// ->field('id,user_id,shopname,avatar,state,level,city,like,createtime')

			->select();

		$row['log'] = model('app\admin\model\wanlshop\RefundLog')

			->where(['refund_id' => $ids])

			->order('createtime desc')

			->select();

	    $this->view->assign("row", $row);

		return $this->view->fetch();

	}

	

	/**

	 * 同意退款

	 */

	public function agree($ids = null)

	{

		$row = $this->model->get($ids);

		if (!$row) {

		    $this->error(__('No Results were found'));

		}

		if ($row['state'] != 3) {

			$this->error(__('當前狀态，不可操作'));

		}

		// 判斷金额

		if(number_format($row['price'], 2) > number_format($row->pay->price, 2)){

			$this->error(__('非法退款金额，金额超过订单金额！！'));

		}

		$result = false;

		Db::startTrans();

		try {

			// 判斷退款类型

			if($row['type'] == 0){

				// 退款完成
				$state = 4;
				
				$order = model('app\index\model\wanlshop\Order')->get($row['order_id']);
			    $shop  = model('app\index\model\wanlshop\Shop')->get($order['shop_id']);

				// 返還资金，並写入日誌，未收货前资金等於凍結在平台无需处理卖家资金流向
				if($order['state'] == 4){
					// 扣商家$order['shop']['user_id']
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$row['price'], $shop['user_id'], '确认收货，同意退款', 'refund', $order['order_no']);

					// 退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '系統同意退款', 'refund', $order['order_no']);
					
					if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					    controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], '壹键批发,货款退回', 'refund', $order['order_no']);
					}
				}else{
					//退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '系統同意退款', 'refund', $order['order_no']);
					if($order['wholesale_id']!=0&&$order['is_wholesale']==1){
					    controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['wholesale_price'], $shop['user_id'], '壹键批发,货款退回', 'refund', $order['order_no']);
					}
				}

				//controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['price'], $row['user_id'], '客戶同意退款', 'refund', $order['order_no']);

			}else if($row['type'] == 1){

				// 先同意退款，還需要买家繼续退货

				$state = 1;

			}else{

				$this->error(__('非法退款类型'));

			}

		    $result = $row->allowField(true)->save(['state' => $state]);

			

			// 退款日誌

			model('app\admin\model\wanlshop\RefundLog')->save([

				'user_id' => $row['user_id'],

				'type' => 2,

				'refund_id' => $ids,

				'content' => '平台判定卖家需配合买家完成退货'

			]);

		    Db::commit();

		} catch (ValidateException $e) {

		    Db::rollback();

		    $this->error($e->getMessage());

		} catch (PDOException $e) {

		    Db::rollback();

		    $this->error($e->getMessage());

		} catch (Exception $e) {

		    Db::rollback();

		    $this->error($e->getMessage());

		}

		if ($result !== false) {

		    $this->success();

		} else {

		    $this->error(__('No rows were updated'));

		}

	}

	

	/**

	 * 平台判定拒絕退款

	 */

	public function refuse($ids = null)

	{

		$row = $this->model->get($ids);

		if (!$row) {

		    $this->error(__('No Results were found'));

		}

		if ($row['state'] != 3) {

			$this->error(__('當前狀态，不可操作'));

		}

		if ($this->request->isPost()) {

		    $params = $this->request->post("row/a");

		    if ($params) {

		        $result = false;

		        Db::startTrans();

		        try {

		            $result = $row->allowField(true)->save(['state' => 5]);

					// 退款日誌

					model('app\admin\model\wanlshop\RefundLog')->save([

						'user_id' => $row['user_id'],

						'type' => 2,

						'refund_id' => $ids,

						'content' => '客服判定：'.$params['refund_content']

					]);

		            Db::commit();

		        } catch (ValidateException $e) {

		            Db::rollback();

		            $this->error($e->getMessage());

		        } catch (PDOException $e) {

		            Db::rollback();

		            $this->error($e->getMessage());

		        } catch (Exception $e) {

		            Db::rollback();

		            $this->error($e->getMessage());

		        }

		        if ($result !== false) {

		            $this->success();

		        } else {

		            $this->error(__('No rows were updated'));

		        }

		    }

		    $this->error(__('Parameter %s can not be empty', ''));

		}

		$this->view->assign("row", $row);

		return $this->view->fetch();

	}

	

	

	

	
}
