<?php
namespace addons\wanlshop\library\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

use Workerman\Worker;
use Workerman\Lib\Timer;
use addons\wanlshop\library\WanlChat\WanlChat;

// 自动加载类
require_once ADDON_PATH . 'wanlshop' . DS . 'library' . DS . 'GatewayWorker' . DS . 'vendor' . DS . 'autoload.php';


class Order extends Command
{
    protected function configure()
    {
        $this->setName('wanlshop:order')
			->addArgument('action', Argument::OPTIONAL, "start|stop|restart|reload|status|connections", 'start')
			->addOption('daemon', 'd', Option::VALUE_NONE, 'Run the workerman server in daemon mode.')
			->setDescription('Wanlshop order refund planning task');
    }

    protected function execute(Input $input, Output $output)
    {
    	$action = $input->getArgument('action');
    	if (DIRECTORY_SEPARATOR !== '\\') {
    	    if (!in_array($action, ['start', 'stop', 'reload', 'restart', 'status', 'connections'])) {
    	        $output->writeln("<error>Invalid argument action:{$action}, Expected start|stop|restart|reload|status|connections .</error>");
    	        return false;
    	    }
    	    global $argv;
    	    array_shift($argv);
    	    array_shift($argv);
    	    array_unshift($argv, 'think', $action);
    	} elseif ('start' != $action) {
    	    $output->writeln("<error>Not Support action:{$action} on Windows.</error>");
    	    return false;
    	}
		
		if ('start' == $action) {
		    $output->writeln('Starting GatewayWorker server...');
		}
		
		// 啟动计劃任务
		$this->plan();
    	Worker::runAll();
    }
    
	
	// 初始化 计劃任务 進程
	public function plan()
	{
		// 全局靜态属性
		if($this->input->hasOption('daemon')){
			// 以daemon(守護進程)方式運行
			Worker::$daemonize = true;
		}
		Worker::$pidFile = '/var/run/wanlorder.pid';
		$worker = new Worker();
		$worker->count = 3; 
		$worker->onWorkerStart = function($worker)
		{
			echo "\r\n";

			echo "WanlShop 计劃任务 啟动成功";

			echo "\r\n";
            
            if($worker->id === 0){
                Timer::add(40, array($this, 'coupon'));
            }
            if($worker->id === 1){
                Timer::add(50, array($this, 'order'));
            }
            if($worker->id === 2){
                Timer::add(60, array($this, 'refund'));
            }
			

			//Timer::add(50, array($this, 'order'));

			//Timer::add(60, array($this, 'refund'));

		};
	}
	

	

	/**

	 * 實時优惠券（方法內使用）

	 *

	 * @ApiSummary  (WanlShop 實時优惠券)

	 *

	 */

	public function coupon()

	{

		echo '[自动优惠券]--开始運行';

		echo "\r\n";

		// 过期优惠券--------------------------------------------------------

		$coupon = model('app\api\model\wanlshop\Coupon')

			->where([

				'invalid' => 0,

				'pretype' => 'fixed',

				'enddate' => ['< time', date("Y-m-d")]

			])

			->setField('invalid', 1);

		if($coupon){

			echo '[自动优惠券]--已清理'.$coupon.'个过期优惠券-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

		// 用戶領取过期优惠券--------------------------------------------------

		$couponReceive = model('app\api\model\wanlshop\CouponReceive');

		// 根据优惠券結束日期 清理已过期

		$fixedTime = $couponReceive->where([

			'state' => 1,

			'pretype' => 'fixed',

			'enddate' => ['< time', date("Y-m-d")]

		])->setField('state', 3);

		if($fixedTime){

			echo '[自动优惠券]--已清理'.$fixedTime.'个过期优惠券-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

		// 根据領取時間 清理已过期

		$list = $couponReceive->where([

			'state' => 1,

			'pretype' => 'appoint',

			'validity' => ['>', 0]

		])->select();

		$coupon_id = [];

		foreach ($list as $row) {

			$endtime = $row['createtime'] + ($row['validity'] * 86400);

			if(time() > $endtime){

				$coupon_id[] = $row['id'];

			}

		}

		$update = $couponReceive

			->where('id', 'in', $coupon_id)

			->setField('state', 3);

		if($update){

			echo '[自动优惠券]--已清理'.$update.'个过期优惠券-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

	}

	

	

	/**

	 * 實時订单（方法內使用）

	 *

	 * @ApiSummary  (WanlShop 實時订单)

	 *

	 */

	public function order()

	{
		echo '[實時订单]--开始運行';

		echo "\r\n";

		$config = get_addon_config('wanlshop');

		$canceltime = time() - ($config['order']['cancel'] * 86400);  // 取消未支付時間

		$receivingtime = time() - ($config['order']['receiving'] * 86400);  // 自动收货時間
		
		$wftuitime = time() - ($config['order']['wftuitime'] * 86400);  // 未发货，自动退款

		$commenttime = time() - ($config['order']['comment'] * 86400);  // 自动评论時間

		

		// 取消未支付-1.0.3升級-釋放库存、优惠券------------------------------------------------------

		$cancel = model('app\api\model\wanlshop\Order')

			->where([

				'state' => 1,

				'createtime' => ['<', $canceltime]

		    ])

			->select();

		if($cancel){

			$list = [];

			foreach($cancel as $order){

				// 查詢商品库存计算方式

				foreach(model('app\api\model\wanlshop\OrderGoods')->all(['order_id' => $order['id']]) as $vo){

					// 查詢商品是否需要釋放库存

					if(model('app\api\model\wanlshop\Goods')->get($vo['goods_id'])['stock'] == 'porder'){

						model('app\api\model\wanlshop\GoodsSku')->where('id', $vo['goods_sku_id'])->setInc('stock', $vo['number']);
					}

				}

				// 釋放优惠券 1.0.3升級

				if($order['coupon_id'] != 0){

					model('app\api\model\wanlshop\CouponReceive')->where(['id' => $order['coupon_id']])->update(['state' => 1]);

				}

				$list[] = ['id' => $order['id'], 'state' => 7];

			}

			model('app\api\model\wanlshop\Order')->isUpdate()->saveAll($list);

			// 日誌

			echo '[取消未支付]--已成功取消'.count($cancel).'个订单未支付订单-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}
		
		
		
		// 取消未发货订单-釋放库存、优惠券------------------------------------------------------

		$wftui = model('app\api\model\wanlshop\Order')

			->where([

				'state' => 2,

				'createtime' => ['<', $wftuitime]

		    ])

			->select();
		

		if($wftui){

			$list = [];
            
			foreach($wftui as $order){
                /*file_put_contents('./dd.txt',(date('Y-m-d h:i:s',time())).' [取消未发货订单]--已成功取消'.$order['id'].'个订单发货订单-----'."\r\n",FILE_APPEND | LOCK_EX );
                $dd = json_encode($list,JSON_FORCE_OBJECT);
		        file_put_contents('./dd.txt',(date('Y-m-d h:i:s',time())).' '.$dd."\r\n",FILE_APPEND | LOCK_EX );*/
				// 查詢商品库存计算方式
				/*foreach(model('app\api\model\wanlshop\OrderGoods')->all(['order_id' => $order['id']]) as $vo){
					// 查詢商品是否需要釋放库存
					if(model('app\api\model\wanlshop\Goods')->get($vo['goods_id'])['stock'] == 'porder'){
						model('app\api\model\wanlshop\GoodsSku')->where('id', $vo['goods_sku_id'])->setInc('stock', $vo['number']);
					}
				}*/
				// 釋放优惠券 1.0.3升級
				if($order['coupon_id'] != 0){
					model('app\api\model\wanlshop\CouponReceive')->where(['id' => $order['coupon_id']])->update(['state' => 1]);
				}
				$list[] = ['id' => $order['id'], 'state' => 7,'remarks'=>'逾期未发货 买家已取消订单'];
				//退款給用戶
				controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['price'], $order['user_id'], '逾期未发货订单自动取消款', 'refund', $order['order_no']);
			}
			model('app\api\model\wanlshop\Order')->isUpdate()->saveAll($list);

			// 日誌

			echo '[取消未发货订单]--已成功取消'.count($wftui).'个订单发货订单-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

		

		// 自动收货-------------------------------------------------------- 后续版本优化 Db::startTrans();

		$receiving = model('app\api\model\wanlshop\Order')

			->where([

				'state' => 3,

				'delivertime' => ['<', $receivingtime]

		    ])

			->select();
		if($receiving){
		    foreach($receiving as $order){
		        file_put_contents('./dd.txt',(date('Y-m-d h:i:s',time())).' 自动收货'.$order['id'].'自动收货--555---'."\r\n",FILE_APPEND | LOCK_EX );
                // 查詢是否有退款
    			$refund = model('app\api\model\wanlshop\Refund')
    				->where(['order_id' => $order['id'], 'state' => 4])
    				->select();
    			// 退款存在
    			if($refund){
    				foreach($refund as $value){
    					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$value['price'], $order['shop']['user_id'], '該订单存在的退款', 'refund', $order['order_no']);
    				}
    			}
    			//$this->pushOrder($order['id'], '已自动收货');
    		    //
    			// 更新退款
    			model('app\api\model\wanlshop\Order')->where(['id' => $order['id']])->update(['state' => 4,'taketime' => time()]);
    			controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$order['pay']['price'], $order['shop']['user_id'], '自动确认收货', 'pay', $order['order_no']);
			}
            
			echo '[自动确认收货]--已确认'.count($receiving).'个订单自动收货-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

		

		// 自动评论--------------------------------------------------------

		$comment = model('app\api\model\wanlshop\Order')

			->where([

				'state' => 4,

				'taketime' => ['<', $commenttime]

		    ])

			->select();

		if($comment){

			foreach($comment as $order){

				$orderGoods = model('app\api\model\wanlshop\OrderGoods')

					->where(['id' => $order['id']])

					->select();

				$commentData = [];

				foreach ($orderGoods as $goods) {

					$commentData[] = [

						'user_id' => $order['user_id'],

						'shop_id' => $goods['shop_id'],

						'order_id' => $goods['order_id'],

						'goods_id' => $goods['goods_id'],

						'order_goods_id' => $goods['id'],

						'state' => 0,

						'content' => '系統默认好评',

						'suk' => $goods['difference'],

						'score' => 5,

						'score_describe' => 5,

						'score_service' => 5,

						'score_deliver' => 5,

						'score_logistics' => 5

					];

					//评论暫不考慮並发，为列表提供好评付款率，減少並发只能写進商品中

					model('app\api\model\wanlshop\Goods')->where(['id' => $goods['goods_id']])->setInc('comment');

					model('app\api\model\wanlshop\Goods')->where(['id' => $goods['goods_id']])->setInc('praise');

				}

				// 推送

				$this->pushOrder($order['id'], '自动评论');

				model('app\api\model\wanlshop\GoodsComment')->saveAll($commentData);

				// 更新退款

				model('app\api\model\wanlshop\Order')->save(['state' => 6,'dealtime' => time()],['id' => $order['id']]);

			}

			echo '[自动默认评论]--已成功评论'.count($comment).'个订单未评论订单-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

	}

	

	/**

	 * 實時退款（方法內使用）

	 *

	 * @ApiSummary  (WanlShop 實時退款)

	 *

	 */

	public function refund()

	{
		echo '[實時退款]--开始運行';

		echo "\r\n";

		$config = get_addon_config('wanlshop');

		$agreetime = time() - ($config['order']['autoagree'] * 86400);  // 卖家 自动同意時間

		$returntime = time() - ($config['order']['returntime'] * 86400);  // 买家退货時間

		$receivingtime = time() - ($config['order']['receivingtime'] * 86400);  // 卖家 收货時間 

		

		

		// 自动同意退货--------------------------------------------------------
		$agreeGoods = model('app\api\model\wanlshop\Refund')
			->where([
				'state' => 0,
				'type' => 1, //退货退款
				'createtime' => ['<', $agreetime]
		    ])
			->select();
		if($agreeGoods){
			$list = [];
			foreach($agreeGoods as $refund){
				$list[] = [
					'id' => $refund['id'],
					'state' => 1,
					'agreetime' => time()
				];
				// 写入日誌
				$this->refundLog($refund['id'], '自动同意退款');
				// 推送消息
				$this->pushRefund($refund['id'], $refund['order_id'], $refund['goods_ids'], $title = '卖家超時退款自动同意');
			}
			model('app\api\model\wanlshop\Refund')->isUpdate()->saveAll($list);
			// 日誌
			echo '[自动同意退款]--已成功同意'.count($agreeGoods).'个退款-----'.date("Y-m-d H:i:s");
			echo "\r\n";
		}
		// 自动同意退款--------------------------------------------------------
		$agreeMoney = model('app\api\model\wanlshop\Refund')
			->where([
				'state' => 0,
				'type' => 0, //退货退款
				'createtime' => ['<', $agreetime]
		    ])
			->select();
		if($agreeMoney){
			$list = [];
			foreach($agreeMoney as $refund){
				// 查詢订单是已确定收货
				$order = model('app\api\model\wanlshop\Order')->get($refund['order_id']);
				// 1.此订单如果已确认收货扣商家
				// 2.此订单沒有确认收货，平台退款	
				if($order['state'] == 4){
					// 扣商家
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$refund['price'], $order['shop']['user_id'], '退单收货超時，自动同意退款', 'refund', $order['order_no']);
					// 退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$refund['price'], $refund['user_id'], '自动同意退款', 'refund', $order['order_no']);
				}else{
					//退款給用戶
					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$refund['price'], $refund['user_id'], '自动同意退款', 'refund', $order['order_no']);
				}
				// 更新所有狀态
				$list[] = [
					'id' => $refund['id'],
					'state' => 4,
					'agreetime' => time()
				];
				// 写入日誌
				$this->refundLog($refund['id'], '自动完成退款');
				// 推送消息
				$this->pushRefund($refund['id'], $refund['order_id'], $refund['goods_ids'], $title = '卖家超時退款自动完成');
			}
			model('app\api\model\wanlshop\Refund')->isUpdate()->saveAll($list);
			// 日誌
			echo '[自动完成退款]--已成功完成'.count($agreeGoods).'个退款-----'.date("Y-m-d H:i:s");
			echo "\r\n";
		}

		// 买家退货時間，如果超時則关闭订单--------------------------------------------------------

		$returns = model('app\api\model\wanlshop\Refund')

			->where([

				'state' => 1,

				'type' => 1, //退货退款

				'agreetime' => ['<', $returntime]

		    ])

			->select();

		if($returns){

			$list = [];

			foreach($returns as $refund){

				$list[] = [

					'id' => $refund['id'],

					'state' => 5,

					'closingtime' => time()

				];

				$this->refundLog($refund['id'], '退货超時，系統自动关闭退款');

				// 推送消息

				$this->pushRefund($refund['id'], $refund['order_id'], $refund['goods_ids'], $title = '退货超時退款已关闭');

			}

			model('app\api\model\wanlshop\Refund')->isUpdate()->saveAll($list);

			echo '[自动同意退款]--已成功同意'.count($returns).'个退款-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

		// 卖家自动收货--------------------------------------------------------

		$receiving = model('app\api\model\wanlshop\Refund')

			->where([

				'state' => 6,

				'returntime' => ['<', $receivingtime]

		    ])

			->select();

		if($receiving){

			$list = [];

			foreach($receiving as $refund){

				// 查詢订单是已确定收货

				$order = model('app\api\model\wanlshop\Order')->get($refund['order_id']);

				// 1.此订单如果已确认收货扣商家

				// 2.此订单沒有确认收货，平台退款	

				if($order['state'] == 4){

					// 扣商家

					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(-$refund['price'], $order['shop']['user_id'], '退单收货超時，自动同意退款', 'refund', $order['order_no']);

					// 退款給用戶

					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$refund['price'], $refund['user_id'], '自动同意退款', 'refund', $order['order_no']);

				}else{

					//退款給用戶

					controller('addons\wanlshop\library\WanlPay\WanlPay')->money(+$refund['price'], $refund['user_id'], '自动同意退款', 'refund', $order['order_no']);

				}

				// 推送消息

				$this->pushRefund($refund['id'], $refund['order_id'], $refund['goods_ids'], $title = '退款已完成');

				// 更新所有狀态

				$list[] = [

					'id' => $refund['id'],

					'state' => 4,

					'completetime' => time()

				];

				// 写入日誌

				$this->refundLog($refund['id'], '收货超時，系統自动同意退款');

			}

			model('app\api\model\wanlshop\Refund')->isUpdate()->saveAll($list);

			echo '[自动同意退款]--已成功同意'.count($receiving).'个退款-----'.date("Y-m-d H:i:s");

			echo "\r\n";

		}

	}

	

    /**
     * 退款日誌（方法內使用）
     *
     * @ApiSummary  (WanlShop 退款日誌)
     * @ApiMethod   (POST)
     * 
     * @param string $refund_id 退款ID
     * @param string $content 日誌內容
     */
    private function refundLog($refund_id = 0, $content = '')
    {
    	return model('app\api\model\wanlshop\RefundLog')->save([
    		'user_id' => 0,
    		'type' => 3,
    		'refund_id' => $refund_id,
    		'content' => $content
    	]);
    }
    
    /**
     * 推送退款消息（方法內使用）
     *
     * @param string refund_id 订单ID
     * @param string order_id 订单ID
     * @param string goods_id 订单ID
     * @param string title 标题
     */
    private function pushRefund($refund_id = 0, $order_id = 0, $goods_id = 0, $title = '')
    {
    	$order = model('app\api\model\wanlshop\Order')->get($order_id);
    	$goods = model('app\api\model\wanlshop\OrderGoods')->get($goods_id);
    	$msg = [
    		'user_id' => $order['user_id'], // 推送目标用戶
    		'shop_id' => $order['shop_id'], 
    		'title' => $title,  // 推送标题
    		'image' => $goods['image'], // 推送圖片
    		'content' => '您申请退款的商品 '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$title, 
    		'type' => 'order',  // 推送类型
    		'modules' => 'refund',  // 模塊类型
    		'modules_id' => $refund_id,  // 模塊ID
    		'come' => '订单'.$order['order_no'] // 來自
    	];
		$chat = new WanlChat();
    	$chat->send($order['user_id'], $msg);
    	$notice = model('app\index\model\wanlshop\Notice');
    	$notice->data($msg);
    	$notice->allowField(true)->save();
    }
    
    /**
     * 订单推送消息（方法內使用）
     * 
     * @param string order_id 订单ID
     * @param string state 狀态
     */
    private function pushOrder($order_id = 0, $state = '已发货')
    {
    	$order = $this->model->get($order_id);
    	$orderGoods = model('app\api\model\wanlshop\OrderGoods')
    		->where(['order_id' => $order_id])
    		->select();
    	$msgData = [];
    	foreach ($orderGoods as $goods) {
    		$msg = [
    			'user_id' => $order['user_id'], // 推送目标用戶
				'shop_id' => $order['shop_id'], 
    			'title' => '您的订单'.$state, // 推送标题
    			'image' => $goods['image'], // 推送圖片
    			'content' => '您购买的商品 '.(mb_strlen($goods['title'],'utf8') >= 25 ? mb_substr($goods['title'],0,25,'utf-8').'...' : $goods['title']).' '.$state, 
    			'type' => 'order',  // 推送类型
    			'modules' => 'order',  // 模塊类型
    			'modules_id' => $order_id,  // 模塊ID
    			'come' => '订单'.$order['order_no'] // 來自
    		];
    		$msgData[] = $msg;
			$chat = new WanlChat();
			$chat->send($order['user_id'], $msg);
    	}
    	$notice = model('app\api\model\wanlshop\Notice')->saveAll($msgData);
    }
	
}