<?php

namespace app\api\controller\wanlshop;



use app\common\controller\Api;

use fast\Random;



/**

 * WanlShop优惠券接口

 */

class Coupon extends Api

{

    protected $noNeedLogin = ['getList', 'query'];

	protected $noNeedRight = ['*'];

    

	/**

	 * 獲取优惠券列表

	 *

	 * @ApiSummary  (WanlShop 优惠券接口獲取优惠券列表)

	 * @ApiMethod   (GET)

	 * 2020年9月15日17:44:57

	 *

	 * @param string $type 类型

	 */

	public function getList($type = null)

	{

		$list = model('app\api\model\wanlshop\Coupon')
		
		    ->where('rangetype', 'in', 'all,wholesale')

			->where([

				'type' => $type,

				//'rangetype' => 'all',

				'invalid' => 0

			])

			->order('createtime desc')

			->paginate()

			->each(function($order, $key){

				$order['shop'] = $order->shop?$order->shop->visible(['shopname']):[];

				return $order;

			});

		$list?($this->success('ok',$list)):($this->error(__('網絡繁忙')));

	}

	

	/**

	 * 查詢我的优惠券

	 *

	 * @ApiSummary  (WanlShop 优惠券接口查詢我的优惠券)

	 * @ApiMethod   (GET)

	 * 2020年9月16日03:32:43

	 *

	 * @param string $goods_id 商品ID

	 * @param string $shop_id 店铺ID

	 * @param string $shop_category_id 分类ID

	 * @param string $price 价格 

	 */

	public function query($goods_id = null, $shop_id = null, $shop_category_id = null, $price = null)

	{

		$user_coupon = [];

		if ($this->auth->isLogin()) {

			foreach (model('app\api\model\wanlshop\CouponReceive')->where([

				'user_id' => $this->auth->id, 

				//'shop_id' => $shop_id,

				'limit' => ['<=', intval($price)],

				'state' => '1'

			])->where('shop_id', 'in', '0,'.$shop_id)->select() as $row) {

				$user_coupon[$row['coupon_id']] = $row;

			}

		}

		// 开始查詢 方案壹

		$list = [];

		$goods_id = explode(",",$goods_id);

		$shop_category_id = explode(",",$shop_category_id);

		//要追加壹个排序 选出壹个性价比最高的

		foreach (model('app\api\model\wanlshop\Coupon')->where([

			//'shop_id' => $shop_id,

			'limit' => ['<=', intval($price)]

		])->where('shop_id', 'in', '0,'.$shop_id)->select() as $row) { 

			// 篩选出還未开始的

			if(!($row['pretype'] == 'fixed' && (strtotime($row['startdate']) >= time() || strtotime($row['enddate']) < time()))){

				//追加字段

				$row['choice'] = false;

				// 檢查指定的键名是否存在於数组中

				if(array_key_exists($row['id'], $user_coupon)){

					$row['invalid'] = 0; // 強制轉換优惠券狀态

					$row['id'] = $user_coupon[$row['id']]['id'];

					$row['state'] = true;

				}else{

					$row['state'] = false;

				}

				// 排除失效优惠券

				if($row['invalid'] == 0){

					// 高級查詢，比較数组，返回交集如果和原数据数目相同則加入
					
					
					if($row['rangetype'] == 'wholesale'){

						$list[] = $row;

					}

					if($row['rangetype'] == 'all'){

						$list[] = $row;

					}

					if($row['rangetype'] == 'goods' && count($goods_id) == count(array_intersect($goods_id, explode(",",$row['range'])))){

						$list[] = $row;

					}

					if($row['rangetype'] == 'category' && count($shop_category_id) == count(array_intersect($shop_category_id, explode(",",$row['range'])))){

						$list[] = $row;

					}

				}

			}

		}

		// 开始查詢 二

		// $list = [];

		// //要追加壹个排序 选出壹个性价比最高的

		// foreach (model('app\api\model\wanlshop\Coupon')->where([

		// 	'shop_id' => $shop_id,

		// 	'limit' => ['<=', intval($price)]

		// ])->select() as $row) { 

		// 	// 如果优惠券狀态有效  或  无效且我的列表中存在的

		// 	if($row['invalid'] == 0 || ($row['invalid'] == 1 && array_key_exists($row['id'], $user_coupon))){

		// 		// 篩选出过期的

		// 		if(!($row['pretype'] == 'fixed' && strtotime($row['startdate']) >= time())){

		// 			// 高級查詢，比較数组，返回交集如果和原数据数目相同則加入

		// 			if($row['rangetype'] == 'goods'){

		// 				$goods_id = explode(",",$goods_id);

		// 				if(count($goods_id) == count(array_intersect($goods_id, explode(",",$row['range'])))){

		// 					// 檢查指定的键名是否存在於数组中

		// 					if(array_key_exists($row['id'], $user_coupon)){

		// 						$row['id'] = $user_coupon[$row['id']]['id'];

		// 						$row['state'] = true;

		// 					}else{

		// 						$row['state'] = false;

		// 					}

		// 					$row['choice'] = false;

		// 					$list[] = $row;

		// 				}

		// 			}else if($row['rangetype'] == 'category'){

		// 				$shop_category_id = explode(",",$shop_category_id);

		// 				if(count($shop_category_id) == count(array_intersect($shop_category_id, explode(",",$row['range'])))){

		// 					if(array_key_exists($row['id'], $user_coupon)){

		// 						$row['id'] = $user_coupon[$row['id']]['id'];

		// 						$row['state'] = true;

		// 					}else{

		// 						$row['state'] = false;

		// 					}

		// 					$row['choice'] = false;

		// 					$list[] = $row;

		// 				}

		// 			}else{

		// 				if(array_key_exists($row['id'], $user_coupon)){

		// 					$row['id'] = $user_coupon[$row['id']]['id'];

		// 					$row['state'] = true;

		// 				}else{

		// 					$row['state'] = false;

		// 				}

		// 				$row['choice'] = false;

		// 				$list[] = $row;

		// 			}

		// 		}

		// 	}

		// }

		return $this->success('ok', $list);

	}

	

	/**

	 * 獲取我的优惠券列表

	 *

	 * @ApiSummary  (WanlShop 优惠券接口獲取我的优惠券列表)

	 * @ApiMethod   (GET)

	 * 2020年9月16日08:09:17

	 *

	 * @param string $state 类型

	 */

	public function getMyList($state = null)

	{

		$list = model('app\api\model\wanlshop\CouponReceive')

			->where([

				'state' => $state, 

				'user_id' => $this->auth->id

			])

			->order('createtime desc')

			->paginate()

			->each(function($order, $key){

				$order['shop'] = $order->shop?$order->shop->visible(['shopname']):[];

				return $order;

			});

		$list?($this->success('ok',$list)):($this->error(__('網絡繁忙')));

	}

	

	/**

	 * 領取优惠券

	 *

	 * @ApiSummary  (WanlShop 优惠券接口領取优惠券)

	 * @ApiMethod   (POST)

	 * 2020年9月16日03:32:43

	 *

	 * @param string $id 优惠券ID

	 */

	public function receive()

	{

		//设置过濾方法

		$this->request->filter(['strip_tags']);

		if ($this->request->isPost()) {

			$id = $this->request->post('id');

			$user_id = $this->auth->id;

			$coupon = model('app\api\model\wanlshop\Coupon')->get($id);

			if(!$coupon){

				$this->error(__('網絡繁忙或优惠券不存在'));

			}

			// 查詢此ID領取幾張

			$myCouponCount = model('app\api\model\wanlshop\CouponReceive')

				->where(['coupon_id' => $id, 'user_id' => $user_id])

				->count();

			// 判斷是否发完

			if($coupon['drawlimit'] != 0){

				if($myCouponCount >= $coupon['drawlimit']){

					$this->error(__('親，您已領取了'.$myCouponCount.'張，不能在領了！'));

				}

			}

			// 判斷是否超出总数量

			if($coupon['grant'] != '-1'){

				if($coupon['alreadygrant'] >= intval($coupon['grant'])  || $coupon['surplus'] == 0){

					$this->error(__('親，您來晚了，剛剛被搶完！'));

				}

			}

			// 判斷优惠券是否过期

			if($coupon['pretype'] == 'fixed'){

				if(time() > strtotime($coupon['enddate'])){

					$this->error(__('此張优惠券已經过期了'));

				}

			}

			// 領取优惠券並保留備份

			$result = model('app\api\model\wanlshop\CouponReceive');

				$result->state = 1;

				$result->coupon_id = $id;

				$result->coupon_no = Random::alnum(16);

				$result->user_id = $user_id;

				$result->shop_id = $coupon['shop_id'];

				$result->type = $coupon['type'];

				$result->name = $coupon['name'];

				$result->userlevel = $coupon['userlevel'];

				$result->usertype = $coupon['usertype'];

				$result->price = $coupon['price'];

				$result->discount = $coupon['discount'];

				$result->limit = $coupon['limit'];

				$result->rangetype = $coupon['rangetype'];

				$result->range = $coupon['range'];

				$result->pretype = $coupon['pretype'];

				$result->validity = $coupon['validity'];

				$result->startdate = $coupon['startdate'];

				$result->enddate = $coupon['enddate'];

				$result->save();

			if($result){

				if($coupon['grant'] != '-1'){

					// 剩余数量

					$data['surplus'] = $coupon['surplus'] - 1;

					// 即將过期，強制失效

					if($coupon['surplus'] == 1){

						$data['invalid'] = 1;

					}

				}

				$data['alreadygrant'] = $coupon['alreadygrant'] + 1;

				// 更新优惠券領取+1

				$coupon->allowField(true)->save($data);

				$this->success(__('ok'),['msg' => '恭喜此券，成功領取第 '.($myCouponCount+1).' 張','id' => $result['id']]);

			}else{

				$this->error(__('網絡繁忙，領取失敗'));

			}

		}

		$this->error(__('非法请求'));

	}

	

	/**

	 * 立即使用优惠券

	 *

	 * @ApiSummary  (WanlShop 优惠券接口立即使用优惠券)

	 * @ApiMethod   (GET)

	 * 2020年9月16日03:32:43

	 * 2020年11月6日10:03:08 1.0.2升級

	 *

	 * @param string $id 优惠券ID

	 */

	public function apply($id = null)

	{

		$coupon = model('app\api\model\wanlshop\CouponReceive')->get($id);

		if($coupon){

			$where['shop_id'] = $coupon['shop_id'];

			$where['price'] = ['>=', $coupon['limit']];

			// 指定商品

			if($coupon['rangetype'] == 'goods'){

				$where['id'] = ['in', $coupon['range']];

			}

			// 指定分类

			if($coupon['rangetype'] == 'category'){

				$where['shop_category_id'] = ['in', $coupon['range']];

			}

			$list = model('app\api\model\wanlshop\Goods')

				->where($where)

				->order('createtime desc')

				->paginate();

			foreach ($list as $row) {

				$row->shop->visible(['id','avatar','shopname']);

			}		

			$this->success('ok', ['coupon' => $coupon,'goods' => $list]);

		}

		$this->error(__('非正常请求'));

	}

}

