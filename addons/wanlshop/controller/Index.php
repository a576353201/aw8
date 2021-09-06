<?php

namespace addons\wanlshop\controller;

use think\addons\Controller;
use think\Db;

class Index extends Controller
{



    protected $model = null;

    public function _initialize()
    {


        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Order;
    }



    /**
     * 分销订单结算
     *
     * @param int       $id         分销订单ID
     */
    public function runCommission($id = null) {
        if (!$id) {
            $id = $this->request->get('id');
        }
        $row = $this->model->get($id);

        $result = Db::transaction(function () use ($row) {
            return (new \addons\wanlshop\library\command\Reward)->runCommisisonRewardlist('admin', $row, $this->auth->getUserInfo());
        });

        if ($result) {
            $this->success('结算成功');
        } else {
            $this->error('订单已结算或没有要结算的佣金');
        }
    }



    public function index()
    {
        $this->error("当前插件暂无前台页面，商家中心通过前台用户中心进入");
    }

}
