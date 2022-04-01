<?php

namespace app\index\controller\wanlshop;

use addons\shopro\model\User as UserModel;
use app\common\controller\Wanlshop;
use think\Db;
use Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

use fast\Tree;

/**
 * 店鋪管理
 * @internal
 */
class Shop extends Wanlshop
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    /**
     * Shop模型對象
     */

    public $user;
    protected $model = null;
    
    public function _initialize()
    {
        parent::_initialize();

        $this->user = model('app\index\model\wanlshop\Auth')::where('invitation', $this->auth->id)->find();

        $this->model = new \app\index\model\wanlshop\Shop;
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("statusList", $this->model->getStatusList());
        
        $this->view->assign("typeList", $this->model->getTypeList());
        $tree = Tree::instance();
        $category = new \app\index\model\wanlshop\Category;// 類目
        $tree->init(collection($category->where(['type' => 'goods'])->order('weigh desc,id desc')->field('id,pid,type,name,name_spacer')->select())->toArray(), 'pid');
        $this->assignconfig('pageCategory', $tree->getTreeList($tree->getTreeArray(0), 'name_spacer'));
    }
    
    /**
     * 類目管理
     */
    public function index()
    {
        return $this->view->fetch('wanlshop/page/index');
    }

	
    /**

     * 品牌管理

     */

    public function brand()

    {

		$this->view->assign("stateList", model('app\index\model\wanlshop\Brand')->getStateList());

        return $this->view->fetch('wanlshop/brand/index');

    }
    
    /**
     * 店鋪資料
     */
    public function profile($ids = null)
    {
        $row = $this->model->get($this->shop->id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷用戶權限
        if ($row['user_id'] !=$this->auth->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $result = false;
                Db::startTrans();
                try {
                    if($row['shopname']!=$params['shopname']){
                        $params['isedit'] = 1;
                    }



                    $result = $row->allowField(true)->save($params);


//                    if($row->dpspjjb!=$params['dpspjjb']){
//
//                    }
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
     * 店鋪資料
     */
    public function invitation($ids = null)
    {
        $row = $this->model->get($this->shop->id);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        // 判斷用戶權限
        if ($row['user_id'] !=$this->auth->id) {
            $this->error(__('You have no permission'));
        }
        if ($this->request->isPost()) {
            
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    

    /**
     * 圖片空間
     */
    public function attachment()
    {
        $attachment = model('Attachment');
        $this->view->assign("picCount", $attachment->where('user_id', $this->auth->id)->count());
        $size = $attachment->where('user_id', $this->auth->id)->sum('filesize');
        $units = array('K','Kb','M','G','T');
        $i = 0;
        for (; $size>=1024 && $i<count($units); $i++) {
            $size /= 1024;
        }
        $this->view->assign("picSum", round($size, 2).$units[$i]);

		$this->view->assign("mimetypeList", \app\common\model\Attachment::getMimetypeList());
        return $this->view->fetch('wanlshop/attachment/index');
    }


    /**
     * 獲取支付日誌
     */
    public function moneyLog()
    { //當前是否爲關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = model('app\common\model\MoneyLog')
                ->where('user_id', $this->auth->id)
                ->order('createtime desc')
                ->count();

            $list = model('app\common\model\MoneyLog')
                ->where('user_id', $this->auth->id)
                ->order('createtime desc')
                ->limit($offset, $limit)
                ->select();




            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }




    function Get_childsusers($members,$mid,$level=0){

        $arr=array();

        foreach ($members as $key => $v) {

            if($v['invitation']==$mid){



                $arr[]=$v;

                $arr = array_merge($arr,$this->Get_childsusers($members,$v['user_id'],$level+1));
                $v['level'] = $level+1;
            }

        }

        return $arr;

    }

     /**
     * 我的團隊
     */
    public function teams()
    {
        $attachment = model('Attachment');
        $this->view->assign("picCount", $attachment->where('user_id', $this->auth->id)->count());
        $size = $attachment->where('user_id', $this->auth->id)->sum('filesize');
        $units = array('K','Kb','M','G','T');
        $i = 0;
        for (; $size>=1024 && $i<count($units); $i++) {
            $size /= 1024;
        }

       $rows= model('app\index\model\wanlshop\Auth')->select();

        $childs=$this->Get_childsusers($rows,$this->auth->id,0);


        foreach ($childs as $k=>$v){

            $sids[]=$v['id'];
        }



        $join = [

            ['fa_wanlshop_commission_reward r','o.id=r.order_id'],
            ['fa_wanlshop_order_goods g','o.id=g.order_id'],


        ];
        $list1 =  Db::table('fa_wanlshop_order')->alias('o')->join($join)->where('o.shop_id', 'in', $sids)->select();

        $pf=[0,0,0];$yj=[0,0,0];
        foreach ($list1 as $k=>$v){
            $v['commission_level']=$v['commission_level']-1;
            $pf[$v['commission_level']]+=$v['wholesale_price']*$v['number'];
            $yj[$v['commission_level']]+=$v['commission'];
        }


        $childslist[0]['pf']=$pf[0];
        $childslist[1]['pf']=$pf[1];
        $childslist[2]['pf']=$pf[2];


        $childslist[0]['yj']=$yj[0];
        $childslist[1]['yj']=$yj[1];
        $childslist[2]['yj']=$yj[2];

        $level = array_column($childs , 'level');
        $level1= in_array('1', $level);
        $level2 = in_array('2', $level);
        $level3 = in_array('3', $level);

       $childslist[0]['count'] = ($level1&&array_count_values(array_column($childs,'level'))[1]) ?array_count_values(array_column($childs,'level'))[1]:0;
        $childslist[1]['count']  = ($level2&&array_count_values(array_column($childs,'level'))[2]) ?array_count_values(array_column($childs,'level'))[2]:0;
        $childslist[2]['count']  = ($level3&&array_count_values(array_column($childs,'level'))[3]) ?array_count_values(array_column($childs,'level'))[3]:0;

        $row = model('app\index\model\wanlshop\Auth')->where(['invitation' => $this->auth->id])->count();

        $this->view->assign("childslist", $childslist);
        $this->view->assign("picSum", round($size, 2).$units[$i]);

       $this->view->assign("lists", ['一級成員','二級成員','三級成員','傭金收入']);

        return $this->view->fetch('wanlshop/teams/index');
    }
    
    /**
     * 類目管理
     */
    public function category()
    {
        return $this->view->fetch('wanlshop/shopsort/index');
    }
    
    /**
     * 服務
     */
    public function service()
    {
        if ($this->request->isAjax()) {
            $where['status'] = 'normal';
            $total = model('app\index\model\wanlshop\ShopService')->where($where)->count();
            $list = model('app\index\model\wanlshop\ShopService')->where($where)->select();
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
    }

	
}
