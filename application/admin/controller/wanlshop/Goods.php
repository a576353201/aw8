<?php

namespace app\admin\controller\wanlshop;

use app\common\controller\Backend;

/**
 * 商品管理
 *
 * @icon fa fa-circle-o
 */
class Goods extends Backend
{
    
    /**
     * Goods模型对象
     * @var \app\admin\model\wanlshop\Goods
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\wanlshop\Goods;
        $this->view->assign("flagList", $this->model->getFlagList());
        $this->view->assign("stockList", $this->model->getStockList());
        $this->view->assign("specsList", $this->model->getSpecsList());
        $this->view->assign("distributionList", $this->model->getDistributionList());
        $this->view->assign("activityList", $this->model->getActivityList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }


    public function zjpl($ids = null)
    {

        $row = $this->model->all($ids);
        $sales = $this->request->post('sales/f', 0);
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            foreach ($row as $vo) {
//                if ($vo['shop_id'] != $this->shop->id) {
//                    $this->error(__('You have no permission'));
//                }
//                if ($vo['wholesale_id'] == 0) {
//                    $this->error('批发订单才能壹键发货');
//                }

                $data=model('app\admin\model\wanlshop\Pinlun')->field("name,type,shop_id")->limit(1)->orderRaw('rand()')->select();
                $userid=model('app\common\model\User')->field("id")->limit(1)->orderRaw('rand()')->find();
                $post['shop']['describe']=$data[0]->type+mt_rand(0,2);
                $post['shop']['service']=$data[0]->type+mt_rand(0,2);
                $post['shop']['deliver']=$data[0]->type+mt_rand(0,2);
                $post['shop']['logistics']=$data[0]->type+mt_rand(0,2);


                $commentData[] = [

                    'user_id' => $userid['id'],

                    'shop_id' => $data[0]->shop_id,

                    'order_id' =>1,

                    'goods_id' => $vo['id'],

                    'order_goods_id' => 1,

                    'state' =>0,

                    'content' =>$data[0]->name,

                    'suk' => '',//$value['difference']

                    'images' => '',//$value['imgList']

                    'score' => round((($post['shop']['describe'] + $post['shop']['service'] + $post['shop']['deliver'] + $post['shop']['logistics']) / 4) ,1),

                    'score_describe' => $post['shop']['describe'],

                    'score_service' => $post['shop']['service'],

                    'score_deliver' => $post['shop']['deliver'],

                    'score_logistics' => $post['shop']['logistics'],

                    'switch' => 0

                ];

                model('app\api\model\wanlshop\Goods')->where(['id' => $vo['id']])->setInc('comment');





//                $order[] = [
//                    'id' => $vo['id'],
//                    'sales' =>$vo['sales']+$sales
//                ];
            }

            if(model('app\api\model\wanlshop\GoodsComment')->saveAll($commentData)){

//                    $order = model('app\api\model\wanlshop\Order')
//
//                        ->where(['id' => $post['order_id'], 'user_id' => $user_id])
//
//                        ->update(['state' => 6]);

            }

            $score = model('app\api\model\wanlshop\GoodsComment')

                ->where(['user_id' => $commentData['user_id']])

                ->select();
            // 從数据集中取出

            $describe = array_column($score,'score_describe');

            $service = array_column($score,'score_service');

            $deliver = array_column($score,'score_deliver');

            $logistics = array_column($score,'score_logistics');

            // 更新店铺评分

            model('app\api\model\wanlshop\Shop')

                ->where(['id' => $post['shop']['id']])

                ->update([

                    'score_describe' => bcdiv(array_sum($describe), count($describe), 1),

                    'score_service' => bcdiv(array_sum($service), count($service), 1),

                    'score_deliver' => bcdiv(array_sum($deliver), count($deliver), 1),

                    'score_logistics' => bcdiv(array_sum($logistics), count($logistics), 1)

                ]);

//            $this->model->saveAll($order);
            $this->success();
        }
        return $this->view->fetch();
    }



    public function zjxl($ids = null)
    {

        $row = $this->model->all($ids);
        $sales = $this->request->post('sales/f', 0);
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            foreach ($row as $vo) {
//                if ($vo['shop_id'] != $this->shop->id) {
//                    $this->error(__('You have no permission'));
//                }
//                if ($vo['wholesale_id'] == 0) {
//                    $this->error('批发订单才能壹键发货');
//                }


                $post['shop']['describe']=3;
                $post['shop']['service']=3;
                $post['shop']['deliver']=3;
                $post['shop']['logistics']=3;


                $commentData[] = [

                    'user_id' => 1,

                    'shop_id' => 2,

                    'order_id' =>1,

                    'goods_id' => 3,

                    'order_goods_id' => 1,

                    'state' =>0,

                    'content' =>'00000',

                    'suk' => '',//$value['difference']

                    'images' => '',//$value['imgList']

                    'score' => round((($post['shop']['describe'] + $post['shop']['service'] + $post['shop']['deliver'] + $post['shop']['logistics']) / 4) ,1),

                    'score_describe' => $post['shop']['describe'],

                    'score_service' => $post['shop']['service'],

                    'score_deliver' => $post['shop']['deliver'],

                    'score_logistics' => $post['shop']['logistics'],

                    'switch' => 0

                ];



                $order[] = [
                    'id' => $vo['id'],
                    'sales' =>$vo['sales']+$sales
                ];
            }

            $this->model->saveAll($order);
            $this->success();
        }
        return $this->view->fetch();
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
    
    public function sales($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }

        $sales = $this->request->post('sales/f', 0);
        if ($sales < 0 || $sales - $row['sales'] == 0) {
            $this->error('没有改变');
        }

        $this->model->startTrans();
        try {
            /*CoinPriceLog::create([
                'coin_id' => $row['id'],
                'admin_id' => $this->auth->id,
                'sales' => $sales,
                'direction' => $sales - $row['sales'] > 0 ? 1 : 2
            ]);*/

            $row->sales = $sales;
            $row->save();

            $this->model->commit();
        } catch (Exception $e) {
            $this->model->rollback();
            $this->error('操作失败');
        }
        $this->success('价格修改成功');
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
