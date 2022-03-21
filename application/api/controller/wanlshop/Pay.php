<?php
namespace app\api\controller\wanlshop;

use addons\wanlshop\library\WanlPay\WanlPay;
use app\common\controller\Api;
use think\Db;
use think\Config;
/**
 * WanlShop支付接口
 */
class Pay extends Api
{
    protected $noNeedLogin = [];
	protected $noNeedRight = ['*'];
    
	/**
	 * 獲取支付信息
	 *
	 * @ApiSummary  (WanlShop 獲取支付信息)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $id 订单ID
	 */
	public function getPay()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$id = $this->request->post('order_id');
			$id ? $id : ($this->error(__('非法请求')));
			// 判斷權限
			$orderState = model('app\api\model\wanlshop\Order')
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->find();
			$orderState['state'] != 1 ? ($this->error(__('订单异常'))):'';
			// 獲取支付信息
			$pay = model('app\api\model\wanlshop\Pay')
				->where('order_id',$id)
				->field('id,order_id,order_no,pay_no,price')
				->find();
			$this->success('ok', $pay);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 支付订单
	 *
	 * @ApiSummary  (WanlShop 支付订单)
	 * @ApiMethod   (POST)
	 * 
	 * @param string $order_id 订单ID
	 * @param string $type 支付类型
	 */
	public function payment()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        
//	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
//	            $this->error('支付密码錯誤');
//	        }
	        
	        
		    $order_id = $this->request->post('order_id/a');
			$order_id ? $order_id : ($this->error(__('非法请求')));
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('未选择支付类型1')));
			// 判斷權限
			$order = model('app\api\model\wanlshop\Order')
                ->where('id', 'in', $order_id)
                ->where('user_id', $user_id)
				->select();
			if(!$order){
			    $this->error(__('沒有找到任何要支付的订单'));
			}
			foreach($order as $item){
				if($item['state'] != 1){
				    $this->error(__('订单已支付，或網絡繁忙'));
				}
			}
			// 調用支付
			$wanlPay = new WanlPay($type, $method, $code);
			$data = $wanlPay->pay($order_id);
			if($data['code'] == 200){
			    $this->success('ok', $data['data']);
			}else{
			    $this->error($data['msg']);
			}
		}
		$this->error(__('非正常请求'));
	}
	
	public function getpaypass()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('支付密码錯誤');
	        }
	        
		     $this->success('ok', 1);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用戶充值
	 */
	public function recharge()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$money = $this->request->post('money');
			$type = $this->request->post('type');
			$method = $this->request->post('method');
			$code = $this->request->post('code');
			$Pay_zg = $this->request->post('Pay_zg');
			$user_id = $this->auth->id;
			$type ? $type : ($this->error(__('未选择支付类型')));
			$money ? $money : ($this->error(__('为输入充值金额')));
			// 調用支付
            if($user_id == 0){
                return ['code' => 10001 ,'msg' => '用戶ID不存在'];
            }
            if($money <= 0){
                return ['code' => 10002 ,'msg' => '充值金额不合法'];
            }
            // 充值订单号
            $pay_no = date("Ymdhis") . sprintf("%08d", $user_id) . mt_rand(1000, 9999);
            // 支付标题
            $title = '充值-' . $pay_no;
            // 生成壹个订单
            $order = \app\api\model\wanlshop\RechargeOrder::create([
                'orderid'   => $pay_no,
                'user_id'   => $user_id,
                'amount'    => $money,
                'payamount' => 0,
                'paytype'   => $type,
                'ip'        => $this->request->ip(),
                'useragent' => substr($this->request->server('HTTP_USER_AGENT'), 0, 255),
                'status'    => 'created'
            ]);

                $this->success('充值申请成功！请等待后台審核', $money);


		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用戶提现賬戶
	 */
	public function getPayAccount()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $row = model('app\api\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->select();
		    $this->success('ok', $row);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 新增提现賬戶
	 */
	public function addPayAccount()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
		    $post = $this->request->post();
		    $post['user_id'] = $this->auth->id;
            $row = model('app\api\model\wanlshop\PayAccount')->allowField(true)->save($post);
		    if($row){
		        $this->success('ok', $row);
		    }else{
		        $this->error(__('新增失敗'));
		    }
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 刪除提现賬戶
	 */
	public function delPayAccount($ids = '')
	{	
		$row = model('app\api\model\wanlshop\PayAccount')
			->where('id', 'in', $ids)
			->where(['user_id' => $this->auth->id])
			->delete();
		if($row){
		    $this->success('ok', $row);
		}else{
		    $this->error(__('刪除失敗'));
		}
	}
	
	/**
	 * 初始化提现
	 */
	public function initialWithdraw()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
			$config = get_addon_config('wanlshop');
		    $bank = model('app\api\model\wanlshop\PayAccount')
		        ->where(['user_id' => $this->auth->id])
		        ->order('createtime desc')
		        ->find();
		    $this->success('ok', [
		        'money' => $this->auth->money,
				'servicefee' => $config['withdraw']['servicefee'],
		        'bank' => $bank
		    ]);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 用戶提现
	 */
	public function withdraw()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('支付密码錯誤');
	        }
	        // 金额
			$money = $this->request->post('money');
			
            // 賬戶
            $account_id = $this->request->post('account_id');
            if ($money <= 0) {
                $this->error('提现金额不正确');
            }
            if ($money > $this->auth->money) {
                $this->error('提现金额超出可提现额度');
            }
            if (!$account_id) {
                $this->error("提现賬戶不能为空");
            }
            // 查詢提现賬戶
            $account = \app\api\model\wanlshop\PayAccount::where(['id' => $account_id, 'user_id' => $this->auth->id])->find();
            if (!$account) {
                $this->error("提现賬戶不存在");
            }
            $config = get_addon_config('wanlshop');
            if ($config['withdraw']['state'] == 'N'){
                $this->error("系統該关闭提现功能，请联系平台客服");
            }
            if (isset($config['withdraw']['minmoney']) && $money < $config['withdraw']['minmoney']) {
                $this->error('提现金额不能低於' . $config['withdraw']['minmoney'] . '$');
            }
            if ($config['withdraw']['monthlimit']) {
                $count = \app\api\model\wanlshop\Withdraw::where('user_id', $this->auth->id)->whereTime('createtime', 'month')->count();
                if ($count >= $config['withdraw']['monthlimit']) {
                    $this->error("已達到本月最大可提现次数");
                }
            }
			// 计算提现手续費
			if($config['withdraw']['servicefee'] && $config['withdraw']['servicefee'] > 0){
				$servicefee = number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
				$handingmoney = $money - number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
			}else{
				$servicefee = 0;
				$handingmoney = $money;
			}
            Db::startTrans();
            try {
                $data = [
                    'user_id' => $this->auth->id,
                    'wtype'   => 0,
                    
                    'money'   => $handingmoney,
                    'name'     => $user['nickname'],
                    'mobile'   => $user['mobile'],
					'handingfee' => $servicefee, // 手续費
                    'type'    => $account['bankCode'],
                    'account' => $account['cardCode'],
                    'username' => $account['username'],
                    'bankname2' => $account['bankName2'],
					'orderid' => date("Ymdhis") . sprintf("%08d", $this->auth->id) . mt_rand(1000, 9999)
                ];
                $withdraw = \app\api\model\wanlshop\Withdraw::create($data);
				$pay = new WanlPay;
				$pay->money(-$money, $this->auth->id, 'application for withdrawal', 'withdraw', $withdraw['id']);
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
			$this->success('提现申请成功！请等待后台審核', $this->auth->money);
		}
		$this->error(__('非正常请求'));
	}
	
	
		/**
	 * 用戶提现
	 */
	public function withdraw2()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
	    if ($this->request->isPost()) {
	        $user    = $this->auth->getUser();
	        $captcha = $this->request->post('captcha');
	        $usdt = $this->request->post('usdt');
	        
	        
			
			$utype = $this->request->post('utype');
			$uaddress = $this->request->post('uaddress');
	        
	        
	        $params  = $this->request->post();
	        $images  = implode(',',$params["images"]);;
	        //var_dump($images);exit;
	        
	        if(empty($user['paypass'])||$user['paypass'] != $captcha){
	            $this->error('支付密码錯誤');
	        }
	        // 金额
			$money = $this->request->post('money');
            // 賬戶
            $account_id = $this->request->post('account_id');
            if ($money <= 0) {
                $this->error('提现金额不正确');
            }
            if ($money > $this->auth->money) {
                $this->error('提现金额超出可提现额度');
            }
            /*if (!$account_id) {
                $this->error("提现賬戶不能为空");
            }
            // 查詢提现賬戶
            $account = \app\api\model\wanlshop\PayAccount::where(['id' => $account_id, 'user_id' => $this->auth->id])->find();
            if (!$account) {
                $this->error("提现賬戶不存在");
            }*/
            $config = get_addon_config('wanlshop');
            if ($config['withdraw']['state'] == 'N'){
                $this->error("系統該关闭提现功能，请联系平台客服");
            }
            if (isset($config['withdraw']['minmoney']) && $money < $config['withdraw']['minmoney']) {
                $this->error('提现金额不能低於' . $config['withdraw']['minmoney'] . '$');
            }
            if ($config['withdraw']['monthlimit']) {
                $count = \app\api\model\wanlshop\Withdraw::where('user_id', $this->auth->id)->whereTime('createtime', 'month')->count();
                if ($count >= $config['withdraw']['monthlimit']) {
                    $this->error("已達到本月最大可提现次数");
                }
            }
			// 计算提现手续費
			if($config['withdraw']['servicefee'] && $config['withdraw']['servicefee'] > 0){
				$servicefee = number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
				$handingmoney = $money - number_format($money * $config['withdraw']['servicefee'] / 1000, 2);
			}else{
				$servicefee = 0;
				$handingmoney = $money;
			}
            Db::startTrans();
            try {
                $data = [
                    'user_id'  => $this->auth->id,
                    'wtype'    => 1,
                    
                    'utype'   => $utype,
                    'uaddress'   => $uaddress,
                    
                    'money'    => $handingmoney,
                    'name'     => $user['nickname'],
                    'mobile'   => $user['mobile'],
					'handingfee' => $servicefee, // 手续費
					'images'   => $images, // images
					'usdt'     => $usdt, // usdt
                    //'type'    => $account['bankCode'],
                    //'account' => $account['cardCode'],
                    //'username' => $account['username'],
                    //'bankname2' => $account['bankName2'],
					'orderid' => date("Ymdhis") . sprintf("%08d", $this->auth->id) . mt_rand(1000, 9999)
                ];
                $withdraw = \app\api\model\wanlshop\Withdraw::create($data);
				$pay = new WanlPay;
				$pay->money(-$money, $this->auth->id, 'application for withdrawal', 'withdraw', $withdraw['id']);
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
			$this->success('提现申请成功！请等待后台審核', $this->auth->money);
		}
		$this->error(__('非正常请求'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function withdrawLog()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Withdraw')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function rechargeLog()
	{
	    //设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Recharge')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 獲取支付日誌
	 */
	public function moneyLog()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\common\model\MoneyLog')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 獲取支付详情
	 */
	public function details($id = null, $type = null)
	{
		if($type == 'pay'){
		    //var_dump($id);exit;
			$order = model('app\api\model\wanlshop\Order')
				->where('order_no', 'in', $id)
				//->where('user_id', $this->auth->id)
				->field('id,shop_id,createtime,paymenttime')
				->select();
			//var_dump($order);exit;
			
			if(!$order){
				$this->error(__('订单被刪除'));
			}
			foreach($order as $vo){
			    $vo->pay->visible(['price','pay_no','order_no','order_price','trade_no','actual_payment','freight_price','discount_price','total_amount']);
				$vo->shop->visible(['shopname']);
				$vo->goods = model('app\api\model\wanlshop\OrderGoods')
					->where(['order_id' => $vo['id']])
					->field('id,title,difference,image,price,number')
					->select();
			}
			$this->success('ok', $order);
		}else if($type == 'recharge' || $type == 'withdraw'){ // 用戶充值
			if($type == 'recharge'){
				$model = model('app\api\model\wanlshop\RechargeOrder');
				$field = 'id,paytype,orderid,memo';
			}else{
				$model = model('app\api\model\wanlshop\Withdraw');
				$field = 'id,money,handingfee,status,type,account,orderid,memo,transfertime';
			}
			$row = $model
				->where(['id' => $id, 'user_id' => $this->auth->id])
				->field($field)
				->find();
			$this->success('ok', $row);
		}else if($type == 'refund'){
			$order = model('app\api\model\wanlshop\Order')
				->where('order_no', $id)
				->where('user_id', $this->auth->id)
				->field('id,shop_id,order_no,createtime,paymenttime')
				->find();
			if(!$order){
				$this->error(__('订单被刪除'));
			}
			$order->shop->visible(['shopname']);
			$order['refund'] = model('app\api\model\wanlshop\Refund')
				->where(['order_id' => $order['id'], 'user_id' => $this->auth->id])
				->field('id,price,type,reason,createtime,completetime')
				->find();
			$this->success('ok', $order);
		}else{ // 系統
			$this->success('ok');
		}
	}
	
	public function getRechargemoney()
	{
	    $recharge_money =  Config::get('site.recharge_money');
		$this->success('ok', $recharge_money);
	}
	
	public function payisok()
	{
	    $payisok =  Config::get('site.payisok');
		$this->success('ok', $payisok);
	}
	
	/**
	 * 儲值金额
	 */
	public function getRecharge()
	{
	    $arr['bank_kaihu'] =  Config::get('site.bank_kaihu');
	    $arr['bank_add']   =  Config::get('site.bank_add');
	    //$arr['bank_name']  =  Config::get('site.bank_name');
	    $arr['bank_num']   =  Config::get('site.bank_num');
	    
	    $arr['usdt_type'] =  Config::get('site.usdt_type');
	    $arr['usdt_qr']   =  Config::get('site.usdt_qr');
	    $arr['usdt_add'] =  Config::get('site.usdt_add');
	    $arr['usdt_er']   =  Config::get('site.usdt_er');
	    $arr['usdt_tips']   =  Config::get('site.usdt_tips');
		$this->success('ok', $arr);
	}
	
	/**
	 * 獲取余额
	 */
	public function getBalance()
	{
		$this->success('ok', $this->auth->money);
	}
	
	
	/**
	 * 獲取余额
	 */
	public function getBalance1()
	{
	    $userid = $this->request->post('userid');
	    $user = model('app\admin\model\User')
				->where(['id' => $userid])
				->find();
		$this->success('ok', $user['money']?$user['money']:0);
	}
	
}