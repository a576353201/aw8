<?php
// 2020年2月17日21:50:49
namespace app\index\controller\wanlshop;

use app\common\controller\Wanlshop;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;


/**
 * 店鋪運費模板
 *
 * @icon fa fa-circle-o
 */
class Freight extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * ShopFreight模型對象
     * 添加 編輯 刪除 批量 回收站 還原
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\index\model\wanlshop\ShopFreight;

		// 判斷地區表是否存在

		if(!db()->query('SHOW TABLES LIKE '."'".config('database.prefix')."area'")) {

			$this->error(__('地區表不存在，請安裝開發示例插件後卸載即可'));

		}

		// 獲取地址

		$this->area = collection(model('app\common\model\Area')->where('level','in',[1,2])->field('id,pid,name,level')->select())->toArray();

		$this->assignconfig('area', $this->getChild(0));

        $this->view->assign("deliveryList", $this->model->getDeliveryList());
        $this->view->assign("isdeliveryList", $this->model->getIsdeliveryList());
        $this->view->assign("valuationList", $this->model->getValuationList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

	
    /**
     * 查看
     */
    public function index()
    {
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果發送的來源是Selectpage，則轉發到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();
    
            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
    
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }
    
    /**
     * 回收站
     */
    public function recyclebin()
    {
        //設置過濾方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->count();
    
            $list = $this->model
                ->onlyTrashed()
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
    
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }
    
    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

			if($params['isdelivery'] == 0 && empty($params['rule'])){

				$this->error(__('自定義運費，必須添加配送區域！！'));

			}
            if ($params) {
                $params['shop_id'] = $this->shop->id;
                $result = false;
                Db::startTrans();
                try {

					$this->model->shop_id = $params['shop_id'];

					$this->model->name = $params['name'];

					$this->model->delivery = $params['delivery'];

					$this->model->isdelivery = $params['isdelivery'];

					if($params['isdelivery'] == 0){

						$this->model->valuation = $params['valuation'];

					}

					if($this->model->save()){

						$result = true;

					}

					// 如果不包郵

					if($params['isdelivery'] == 0){

						// 寫入模板數據

						$list = [];

						foreach ($params['rule']['first'] as $key => $value) {

							$list[] = [

								'shop_id' => $params['shop_id'],

								'freight_id' => $this->model->id,

								'province' => $params['rule']['province'][$key],

								'citys' => $params['rule']['citys'][$key],

								'first' => $params['rule']['first'][$key],

								'first_fee' => $params['rule']['first_fee'][$key],

								'additional' => $params['rule']['additional'][$key],

								'additional_fee' => $params['rule']['additional_fee'][$key]

							];

						}

						if(!model('app\index\model\wanlshop\ShopFreightData')->allowField(true)->saveAll($list)){

							$result = false;

						}

					}

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
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }
    
    /**
     * 編輯
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($row['shop_id'] !=$this->shop->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $result = false;

				$results = false;
                Db::startTrans();
                try {
                    $result = $row->allowField(true)->save($params);

					// 如果不包郵寫入數據，否則刪除

					if($params['isdelivery'] == 0){

						// 刪除原來數據

						model('app\index\model\wanlshop\ShopFreightData')

							->where('freight_id','in',$ids)

							->delete();

						// 生成新數據

						$list = [];

						foreach ($params['rule']['first'] as $key => $value) {

							$list[] = [

								'shop_id' => $row['shop_id'],

								'freight_id' => $ids,

								'province' => $params['rule']['province'][$key],

								'citys' => $params['rule']['citys'][$key],

								'first' => $params['rule']['first'][$key],

								'first_fee' => $params['rule']['first_fee'][$key],

								'additional' => $params['rule']['additional'][$key],

								'additional_fee' => $params['rule']['additional_fee'][$key]

							];	

						}

						$results = model('app\index\model\wanlshop\ShopFreightData')->allowField(true)->saveAll($list);

					}else{

						// 刪除原來數據

						model('app\index\model\wanlshop\ShopFreightData')

							->where('freight_id','in',$ids)

							->delete();

					}

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
                if ($result !== false || $results !== false ) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

		$this->assignconfig('data', collection($row->freightdata)->toArray());

		$this->assignconfig('valuation', $row['valuation']);

		$this->assignconfig('isdelivery', $row['isdelivery']);

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    
    /**
     * 刪除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $this->model->where('shop_id', '=', $this->shop->id);
            $list = $this->model->where($pk, 'in', $ids)->select();
            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $value) {
                    $count += $value->delete();

					// 如果不包郵

					if($value['isdelivery'] == 0){

						// 刪除模板數據

						model('app\index\model\wanlshop\ShopFreightData')

							->where('freight_id','in',$value['id'])

							->delete();

					}

                }

                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
    
    
    
    /**
     * 還原
     */
    public function restore($ids = "")
    {
        $pk = $this->model->getPk();
        $this->model->where('shop_id', '=', $this->shop->id);
        if ($ids) {
            $this->model->where($pk, 'in', $ids);
        }
        $count = 0;
        Db::startTrans();
        try {
            $list = $this->model->onlyTrashed()->select();
            foreach ($list as $index => $item) {
                $count += $item->restore();

				if($item['isdelivery'] == 0){

					// 還原模板數據

					model('app\index\model\wanlshop\ShopFreightData')

						->where('freight_id','in',$item['id'])

						->restore();

				}

            }
            Db::commit();
        } catch (PDOException $e) {
            Db::rollback();
            $this->error($e->getMessage());
        } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($count) {
            $this->success();
        }
        $this->error(__('No rows were updated'));
    }
    
    /**
     * 批量更新
     */
    public function multi($ids = "")
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids) {
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                // $values = $this->auth->isSuperAdmin() ? $values : array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                if ($values) {
                    $this->model->where('shop_id', '=', $this->shop->id);
                    $count = 0;
                    Db::startTrans();
                    try {
                        $list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
                        foreach ($list as $index => $item) {
                            $count += $item->allowField(true)->isUpdate(true)->save($values);
                        }
                        Db::commit();
                    } catch (PDOException $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    } catch (Exception $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    }
                    if ($count) {
                        $this->success();
                    } else {
                        $this->error(__('No rows were updated'));
                    }
                } else {
                    $this->error(__('You have no permission'));
                }
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

	

	/**

	 * 內部得到子級數組方法，開發者不要外部調用

	 * @param int

	 * @return array

	 */

	public function getChild($myid)

	{

	    $newarr = [];

	    foreach ($this->area as $key => $value) {

	        if (!isset($value['id'])) {

	            continue;

	        }

	        if ($value['pid'] == $myid) {

	            $newarr[$value['id']] = $value;

				$newarr[$value['id']]['city'] = $this->getChild($value['id']);

	        }

	    }

	    return $newarr;

	}
}
