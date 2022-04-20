<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;
use fast\Tree;

/**
 * 商品管理
 *
 * @icon fa fa-circle-o
 */
class Caiji extends Backend
{
    
    /**
     * Goods模型對象
     * @var \app\admin\model\wanlshop\Goods
     */
    protected $model = null;
    protected $flmodel = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Goods;
        $tree = Tree::instance();

        $this->flmodel = new \app\admin\model\wanlshop\Category;


        $type = $this->request->request("type");
        if($type){
            $tree->init(collection($this->flmodel->where('type', $type)->order('weigh desc,id desc')->select())->toArray(), 'pid');
        }else{
            $tree->init(collection($this->flmodel->order('weigh desc,id desc')->select())->toArray(), 'pid');
        }
        $this->channelList = $tree->getTreeList($tree->getTreeArray(0), 'name');
        $this->view->assign("channelList", $this->channelList);
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("stockList", $this->model->getStockList());
        $this->view->assign("specsList", $this->model->getSpecsList());
        $this->view->assign("distributionList", $this->model->getDistributionList());
        $this->view->assign("activityList", $this->model->getActivityList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function cjstart1($ids = null)
    {


        $catid = $this->request->post('catid');
        $keyword = $this->request->post('keyword');
        $price_min = $this->request->post('price_min');
        $limit = $this->request->post('limit');
        $catid=1;
//$keyword='iphone 13';
        $keyword=urlencode($keyword);


        $var = 'pen';
        $var1 = 12;
        $l = exec("G:/mypython/venv/Scripts/python.exe G:/mypython/xiapa_pf.py  $keyword $catid $price_min $limit",$Array,$ret);


        $this->success();
    }


    public function cjstart122($ids = null)
    {

        $dd=1;



        $catid = $this->request->post('catid');
        $keyword = $this->request->post('keyword');
       //$l = exec("cd /www/wwwroot/pythcj  $var $var1",$Array,$ret1);
      // $l1 =exec("source /www/wwwroot/pythcj/env/bin/activate",$Array,$ret);
      //  echo   $ret;
        $keyword=rawurlencode($keyword);
  // echo   $ret1;
        $set_charset = 'export LANG=en_US.UTF-8;';
      //$l = exec($set_charset."/usr/bin/python /www/wwwroot/pythcj.com/xiapa_pf.py  $var $var1",$Array,$ret2);
        $l = exec("/usr/bin/python /www/wwwroot/pythcj.com/xiapa_pf.py  $keyword $catid",$Array,$ret2);
//
//        print_r($Array);
//        echo   $ret2;
//
//        die;
        //echo($Array[0]);die;

        $this->success();
    }
    /**
     * 查看
     */
    public function index()
    {


        //當前是否爲關聯查詢
        $this->relationSearch = true;
        //設置過濾方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果發送的來源是Selectpage，則轉發到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['category','shopsort','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
    
            $list = $this->model
                    ->with(['category','shopsort','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
    
            foreach ($list as $row) {
                $row->getRelation('category')->visible(['name']);
                $row->getRelation('shopsort')->visible(['name']);
                $row->getRelation('shop')->visible(['shopname']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
       return $this->view->fetch();
    }

	/**
	 * 選擇鏈接
	 */
	public function select()
	{
	    if ($this->request->isAjax()) {
	        return $this->index();
	    }
	    return $this->view->fetch();
	}
}