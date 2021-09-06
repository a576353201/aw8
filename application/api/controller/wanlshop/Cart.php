<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;

/**
 * WanlShop购物车接口
 */
class Cart extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    

	public function _initialize()

	{

	    parent::_initialize();

	    $this->model = new \app\api\model\wanlshop\Cart;

	}

	

	/**
	 * 獲取或合並购物车
	 *
	 * @ApiSummary  (WanlShop 购物车接口獲取或合並购物车)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $cart 本地购物车数据
	 */
	public function synchro()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
			$user_id = $this->auth->id;
			// 如果存在合並购物车，返回；否則獲取购物车
			if($post['cart']){
			    $newlist = [];
				foreach($post['cart'] as $row){
					$where = [
						'goods_id' => $row['goods_id'],
						'shop_id' => $row['shop_id'],
						'sku_id' => $row['sku_id'],
						'user_id' => $user_id
					];
					$cart = $this->model->where($where)->find();
					if(!$cart){

						// 局部写入 1.0.2升級

						$where['number'] = $row['number'];
					    $newlist[] = $where;

					}
				}
				if(count($newlist) > 0){
				    $this->model->saveAll($newlist, false);
				}
			}

			// 查詢购物车最新商品详情 1.0.2升級
			$list = [];

			foreach ($this->model->where('user_id', $user_id)->select() as $vo) {

				$sku = $vo->suk; //1.0.3升級 很詭异的问题命名sku和会产生沖突

				// 查詢是否還有库存

				if($sku['stock'] > 0){

					$shop = $vo->shop;

					$goods = $vo->goods;

					$list[] = [

						'shop_id' => $shop['id'],

						'shop_name' => $shop['shopname'],

						'goods_id' => $goods['id'],

						'title' => $goods['title'],

						'image' => $goods['image'],

						'number' => $vo['number'],

						'sku_id' => $vo['sku_id'],

						'sku' => $sku,

						'sum' => bcmul($sku['price'], $vo['number'], 2),

						'checked' => false,

						

					];

				}

			}	

			$this->success('返回成功', $list);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 操作购物车数据库
	 *
	 * @ApiSummary  (WanlShop 购物车接口操作购物车数据库)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $type 操作方式
	 * @param string $data 改變数据
	 */
	public function storage()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
			$user_id = $this->auth->id;
			$return = '';
			// 清空购物车
			if($post['type'] == 'empty'){
			    $this->model->where(['user_id' => $this->auth->id])->delete();
			// 新增购物车
			}else if($post['type'] == 'add'){
			    $row = $post['data'];
			    $where = [
					'goods_id' => $row['goods_id'],
					'shop_id' => $row['shop_id'],
					'sku_id' => $row['sku_id'],
					'user_id' => $user_id
				];
				// 查詢是否已存在，如果已存在只改變数量和总价
				$cart = $this->model->where($where)->find();
			    if($cart){
			        $number = $cart['number'] + $row['number'];
    				$params = [
    					'number' => $number,
    					'sum' => bcmul($cart['sku']['price'], $number)
    				];
    				$cart->save($params);
				}else{

					// 只新增ID，1.0.2升級

					$where['number'] = $row['number'];

				    $this->model->save($where, false);
				}
			// 新增购物车
			}else if($post['type'] == 'bcsub' || $post['type'] == 'bcadd'){	
			    $where = [
					'goods_id' => $post['goods_id'],
					'sku_id' => $post['sku_id'],
					'user_id' => $user_id
				];
				$cart = $this->model->where($where)->find();
				$cart->save(['number' => $post['number'], 'sum' => $post['sum']]);
			// 批量刪除
			}else if($post['type'] == 'del'){	
				foreach ($post['data'] as $row) {
		            $where = [
    					'goods_id' => $row['goods_id'],
    					'sku_id' => $row['sku_id'],
    					'user_id' => $user_id
    				];
                    $this->model->where($where)->delete();
                }
			// 先將传來的批量写進关注表，在刪除這些
			}else if($post['type'] == 'follow'){
			    $follow = [];
				foreach ($post['data'] as $row) {
		            $where = [
    					'goods_id' => $row['goods_id'],
    					'sku_id' => $row['sku_id'],
    					'user_id' => $user_id
    				];
    				$follow[] = [
    				    'user_id' => $user_id,
    				    'goods_id' => $row['goods_id']
    				];
                    $this->model->where($where)->delete();
                }
                $follow = array_unique($follow, SORT_REGULAR);
                $return = model('app\api\model\wanlshop\GoodsFollow')->saveAll($follow, false);
                $return = count($return);
			}else{
			    $this->error(__('網絡繁忙'));
			}
			$this->success('更新购物车完成！', $return);
		}
		$this->error(__('非正常请求'));
	}

}
