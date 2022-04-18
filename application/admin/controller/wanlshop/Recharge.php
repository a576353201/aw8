<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use think\Db;
/**
 * 意见反馈表 
 *
 * @icon fa fa-circle-o
 */
class Recharge extends Backend
{
    
    /**
     * Recharge模型对象
     * @var \app\admin\model\wanlshop\Recharge
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Recharge;
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);

            foreach ($list as $k=>&$v){

                $v['username']=model('app\common\model\User')->where(['id' =>$v['user_id']])->find();

                $v['username']=$v['username']->username;
$dd=1;
$dd=1;

            }



            $result = array("total" => $list->total(), "rows" => $list->items());

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

        $row['images']=unserialize($row['images'][0]);

        if (!$row) {

            $this->error(__('No Results were found'));

        }

    	if ($this->request->isPost()) {

    	    $params = $this->request->post("row/a");

    	    if ($params) {

    	        $params = $this->preExcludeFields($params);

    	        $result = false;

    	        Db::startTrans();

    	        try {

    	            //是否采用模型验证

    	            if ($this->modelValidate) {

    	                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));

    	                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;

    	                $row->validateFailException(true)->validate($validate);

    	            }

					$params['status'] = 'hidden';

    	            $result = $row->allowField(true)->save($params);

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



    /**
     * 變更会员余额
     * @param int    $money   余额
     * @param int    $user_id 会员ID
     * @param string $memo    備注
     * @param string $type    类型
     * @param string $ids  	  業务ID
     */
    public  function money($money, $user_id, $memo, $type = '', $ids = '')
    {
        $user = model('app\common\model\User')->get($user_id);
        if ($user && $money != 0) {
            $before = $user->money;
            $after = function_exists('bcadd') ? bcadd($user->money, $money, 2) : $user->money + $money;
            //更新会员信息
            $user->save(['money' => $after]);
            //写入日誌
            $row = model('app\common\model\MoneyLog')->create([
                'user_id' => $user_id,
                'money' => $money, // 操作金额
                'before' => $before, // 原金额
                'after' => $after, // 增加后金额
                'memo' => $memo, // 備注
                'type' => $type, // 类型
                'service_ids' => $ids // 業务ID
            ]);
            return $row;
        }else{

            return ['code' => 500 ,'msg' => '變更金额失敗'];

        }
    }
    
    
    /**

     * 同意

     */

    public function agree($ids = null)

    {

    	$row = $this->model->get($ids);

    	if (!$row) {

    	    $this->error(__('No Results were found'));

    	}

    	$adminIds = $this->getDataLimitAdminIds();

    	if (is_array($adminIds)) {

    	    if (!in_array($row[$this->dataLimitField], $adminIds)) {

    	        $this->error(__('You have no permission'));

    	    }

    	}

    	if ($row['status'] == 'successed') {

    	    $this->error(__('已审核过本店铺，请不要重复审核！'));

    	}

    	if ($this->request->isPost()) {

    		$result = false;

    		Db::startTrans();

    		try {

    		    //是否采用模型验证

    		    if ($this->modelValidate) {

    		        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));

    		        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;

    		        $row->validateFailException(true)->validate($validate);

    		    }

    			// 审核通过

    		    $result = $row->allowField(true)->save([

					'status' => 'paid',

					'updatetime' => time()

				]);
				
				// 更新用户金额
                self::money(+$row['amount'], $row['user_id'], '儲值成功', 'recharge', $row['id']);

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

    	$this->view->assign("row", $row);

    	return $this->view->fetch();

    }

    

    /**

     * 拒绝

     */

    public function refuse($ids = null)

    {

    	$row = $this->model->get($ids);

    	if (!$row) {

    	    $this->error(__('No Results were found'));

    	}

    	$adminIds = $this->getDataLimitAdminIds();

    	if (is_array($adminIds)) {

    	    if (!in_array($row[$this->dataLimitField], $adminIds)) {

    	        $this->error(__('You have no permission'));

    	    }

    	}

    	if ($this->request->isPost()) {

    	    $params = $this->request->post("row/a");

    	    if ($params) {

    	        $params = $this->preExcludeFields($params);

    	        $result = false;

    	        Db::startTrans();

    	        try {

    	            //是否采用模型验证

    	            if ($this->modelValidate) {

    	                $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));

    	                $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;

    	                $row->validateFailException(true)->validate($validate);

    	            }

    				$params['status'] = 'rejected';

    	            $result = $row->allowField(true)->save($params);

					// 更新用户金额

					//controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$row['money'], $row['user_id'], '提现失败返回余额', 'withdraw', $row['id']);

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
