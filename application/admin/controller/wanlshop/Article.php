<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 文章
 *
 * @icon fa fa-circle-o
 */
class Article extends Backend
{
    
    /**
     * Article模型对象
     * @var \app\admin\model\wanlshop\Article
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Article;
        $channelList = [];
        foreach (collection(\app\admin\model\wanlshop\Category::where(['type' => 'article'])->select())->toArray() as $k => $v) {
            $channelList[] = [
                'id'     => $v['id'],
                'parent' => $v['pid'] ? $v['pid'] : '#',
                'text'   => __($v['name']),
                'type'   => $v['type'],
                'state'  => ['opened' => true]
            ];
        }
        $this->assignconfig('channelList', $channelList);
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();
    
            $list = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
    
            foreach ($list as $row) {
                $row->getRelation('category')->visible(['name']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
    
            return json($result);
        }
        return $this->view->fetch();
    }
    
	/**
	 * 选择链接
	 */
	public function select()
	{
	    if ($this->request->isAjax()) {
	        return $this->index();
	    }
	    return $this->view->fetch();
	}
	
}
