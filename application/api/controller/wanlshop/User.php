<?php

namespace app\api\controller\wanlshop;

use addons\wanlshop\library\Decrypt\weixin\wxBizDataCrypt;
use addons\wanlshop\library\WanlChat\WanlChat;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use fast\Http;
use think\Validate;

/**
 * WanlShop会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'logout', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third', 'phone', 'perfect'];
    protected $noNeedRight = ['*'];
    
    public function _initialize()
    {
        parent::_initialize();
        //WanlChat 即时通讯调用
		$this->wanlchat = new WanlChat();
		$this->auth->setAllowFields(['id','username','nickname','mobile','avatar','level','gender','birthday','bio','money','score','successions','maxsuccessions','prevtime','logintime','loginip','jointime']);
    }

    /**
     * 会员登录
     * @ApiMethod   (POST)
     * @param string $account  账号
     * @param string $password 密码
     */
    public function login()
    {
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$account = $this->request->post('account');
			$password = $this->request->post('password');
			$client_id = $this->request->post('client_id');
			if (!$account || !$password) {
				$this->error(__('Invalid parameters'));
			}
			$ret = $this->auth->login($account, $password);
			if ($ret) {
			    if($client_id){
			    //  $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Logged in successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('非法请求'));
    }

    /**
     * 手机验证码登录
     * @ApiMethod   (POST)
     * @param string $mobile  手机号
     * @param string $captcha 验证码
     */
    public function mobilelogin()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post('mobile');
			$captcha = $this->request->post('captcha');
			$client_id = $this->request->post('client_id');
			if (!$mobile || !$captcha) {
				$this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^09\d{8}$")) {
				$this->error(__('Mobile is incorrect'));
			}
			if (!Sms::check($mobile, $captcha, 'mobilelogin')) {
				$this->error(__('Captcha is incorrect'));
			}
			$user = \app\common\model\User::getByMobile($mobile);
			if ($user) {
				if ($user->status != 'normal') {
					$this->error(__('Account is locked'));
				}
				//如果已經有賬号則直接登录
				$ret = $this->auth->direct($user->id);
			} else {
				$ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
			}
			if ($ret) {
				Sms::flush($mobile, 'mobilelogin');
				if($client_id){
			        $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Logged in successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('非法请求'));
    }
    
    /**
     * 手机号登录
     * @ApiMethod   (POST)
     * @param string $encryptedData  
     * @param string $iv  
     */
    public function phone()
    {
        //设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
		    if (!isset($post['iv'])) {
		        $this->error(__('獲取手机号异常'));
		    }
		    // 獲取配置
		    $config = get_addon_config('wanlshop');
		    // 微信小程序一键登录
	        $params = [
			    'appid'    => $config['mp_weixin']['appid'],
			    'secret'   => $config['mp_weixin']['appsecret'],
			    'js_code'  => $post['code'],
			    'grant_type' => 'authorization_code'
			    ];
		    $result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
		    $json = (array)json_decode($result['msg'], true);
		    // 判斷third是否存在ID,存在快速登录
			if(isset($json['unionid'])){
				$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'mp_weixin', 'unionid' => $json['unionid']]);
			}else{
				$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'mp_weixin', 'openid' => $json['openid']]);
			}
			
		    if ($third && $third['user_id'] != 0) {
		        //如果已經有賬号則直接登录
    			$ret = $this->auth->direct($third['user_id']);
		    } else {
    		    // 手机号解码
    		    $decrypt = new wxBizDataCrypt($config['mp_weixin']['appid'], $json['session_key']);
                $decrypt->decryptData($post['encryptedData'], $post['iv'], $data);
                $data = (array)json_decode($data, true);
                // 开始登录
    		    $mobile = $data['phoneNumber'];
    			$user = \app\common\model\User::getByMobile($mobile);
    			if ($user) {
    				if ($user->status != 'normal') {
    					$this->error(__('Account is locked'));
    				}
    				//如果已經有賬号則直接登录
    				$ret = $this->auth->direct($user->id);
    			} else {
    				$ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
    			}
		    }

			
		    if ($ret) {
		        if (isset($post['client_id']) && $post['client_id'] != null) {
    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
    		    }
    			$data = [
    				'userinfo' => $this->auth->getUserinfo(),
    				'statistics' => $this->statistics()
    			];
    			$this->success(__('Logged in successful'), $data);
    		} else {
    			$this->error($this->auth->getError());
    		}
		}
		$this->error(__('非法请求'));
    }
    
    
    /**
     * 注冊会员
     * @ApiMethod   (POST)
     * @param string $mobile   手机号
     * @param string $code   验证码
     */
    public function register()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post('email');
			$password = $this->request->post('password');
			
			$code = $this->request->post('captcha');
			$client_id = $this->request->post('client_id');
			if ($mobile && !Validate::is($mobile, "email")) {
				$this->error(__('email is incorrect'));
			}
			$ret = Ems::check($mobile, $code, 'register');
			if (!$ret) {
				//$this->error(__('Captcha is incorrect'));
			}
			//Random::alnum()
			$ret = $this->auth->register($mobile, $password, $mobile, '', []);
			if ($ret) {
			    $ret = $this->auth->login($mobile, $password);
			    if($client_id){
			    //    $this->wanlchat->bind($client_id, $this->auth->id);
			    }
				$data = [
					'userinfo' => $this->auth->getUserinfo(),
					'statistics' => $this->statistics()
				];
				$this->success(__('Sign up successful'), $data);
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('非法请求'));
    }

    /**
     * 注销登录
     */
    public function logout($client_id = null)
    {
        // 踢出即時通讯
        if($client_id){
            $this->wanlchat->destoryClient($client_id);
        }
        // 退出登录
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }
    
    
    public function getpaypass()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			if(!empty($user['paypass'])){
			    $this->success('返回成功',1);
			}else{
			    $this->success('返回成功',0);
			}
		}
    }
    
    /**
     * 重置密码
     * @ApiMethod   (POST)
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetloginpass()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $user = $this->auth->getUser();
			
			$oldpay   = $this->request->post('oldpay');
			$newpay   = $this->request->post('newpay');
			$renewpay = $this->request->post('renewpay');
			
			
			if($newpay!=$renewpay){
			    $this->error('兩次密码输入不一致');
			}
			//var_dump($user);exit;
			if(md5(md5($oldpay) . $user['salt'])==$user['password']){
			    //$ret = $this->auth->changepwd($newpay, '', true);
			    $user->password = md5(md5($newpay) . $user['salt']);
    			$user->save();
    		    $this->success(__('Reset password successful'));
			}else{
			    $this->error('旧密码输入錯誤');
			}
		}
		$this->error(__('非法请求'));
    }
    
    public function resetpass()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			
			$oldpay   = $this->request->post('oldpwd');
			$newpay   = $this->request->post('newpwd');
			$renewpay = $this->request->post('newpwd1');
			
			
			if($newpay!=$renewpay){
			    $this->error('兩次密码输入不一致');
			}
			if(!empty($user['paypass'])&&$user['paypass']==$oldpay){
			    $user->paypass = $newpay;
    			$user->save();
    			$this->success('返回成功',$user);
			}else{
			    if(empty($user['paypass'])){
			        $user->paypass = $newpay;
        			$user->save();
        			$this->success('返回成功',$user);
			    }
			    $this->error('旧密码输入錯誤1');
			}
		
		}
		$this->error(__('非法请求'));
    }

    /**
     * 修改会员个人信息
     * @ApiMethod   (POST)
	 *
     * @param string $avatar   頭像地址
     * @param string $username 用戶名
     * @param string $nickname 昵称
     * @param string $bio      个人簡介
     */
    public function profile()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			$avatar = $this->request->post('avatar', '', 'trim,strip_tags,htmlspecialchars');
			if($avatar){
				$user->avatar = $avatar;
			}else{
				$username = $this->request->post('username');
				$nickname = $this->request->post('nickname');
				$bio = $this->request->post('bio');
				if ($username) {
					$exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
					if ($exists) {
						$this->error(__('Username already exists'));
					}
					$user->username = $username;
				}
				$user->nickname = $nickname;
				$user->bio = $bio;
			}
			$user->save();
			$this->success('返回成功',$user);
		}
		$this->error(__('非法请求'));
    }

    /**
     * 修改手机号
     * @ApiMethod   (POST)
     * @param string $email   手机号
     * @param string $captcha 验证码
     */
    public function changemobile()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$user = $this->auth->getUser();
			$mobile = $this->request->request('mobile');
			$captcha = $this->request->request('captcha');
			if (!$mobile || !$captcha) {
			    $this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^09\d{8}$")) {
			    $this->error(__('Mobile is incorrect'));
			}
			if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
			    $this->error(__('Mobile already exists'));
			}
			$result = Sms::check($mobile, $captcha, 'changemobile');
			if (!$result) {
			    $this->error(__('Captcha is incorrect'));
			}
			$verification = $user->verification;
			$verification->mobile = 1;
			$user->verification = $verification;
			$user->mobile = $mobile;
			$user->save();
			
			Sms::flush($mobile, 'changemobile');
			$this->success();
		}
		$this->error(__('非法请求'));
    }
    
    /**
     * 重置密码
     * @ApiMethod   (POST)
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetpwd()
    {
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$mobile = $this->request->post("mobile");
			$newpassword = $this->request->post("newpassword");
			$captcha = $this->request->post("captcha");
			if (!$newpassword || !$captcha || !$mobile) {
				$this->error(__('Invalid parameters'));
			}
			if (!Validate::regex($mobile, "^09\d{8}$")) {
				$this->error(__('Mobile is incorrect'));
			}
			$user = \app\common\model\User::getByMobile($mobile);
			if (!$user) {
				$this->error(__('User not found'));
			}
			$ret = Sms::check($mobile, $captcha, 'resetpwd');
			if (!$ret) {
				$this->error(__('Captcha is incorrect'));
			}
			Sms::flush($mobile, 'resetpwd');
			//模擬一次登录
			$this->auth->direct($user->id);
			$ret = $this->auth->changepwd($newpassword, '', true);
			if ($ret) {
				$this->success(__('Reset password successful'));
			} else {
				$this->error($this->auth->getError());
			}
		}
		$this->error(__('非法请求'));
    }
    
    /**
     * 第三方登录-web登录
     * @ApiMethod   (POST)
     * @param string $platform 平台名称
     */
    public function third_web()
    {
        $this->error(__('暫未开放'));
    }
    
    
    /**
     * 第三方登录
     * @ApiMethod   (POST)
     * @param string $platform 平台名称
     * @param string $code     Code码
     */
    public function third()
    {
        //设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    // 獲取登录配置
			$config = get_addon_config('wanlshop');
			// 獲取前端參数
			$post = $this->request->post();
			// 登录項目
			$time = time();
			$platform = $post['platform'];
			// 开始登录
			switch ($platform)
			{
				// 微信小程序登录
				case 'mp_weixin':
					$params = [
						'appid'      => $config[$platform]['appid'],
						'secret'     => $config[$platform]['appsecret'],
						'js_code'    => $post['loginData']['code'],
						'grant_type' => 'authorization_code'
					];
					$result = Http::sendRequest("https://api.weixin.qq.com/sns/jscode2session", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
						}
                        // 成功登录
                        if ($third) {
                            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
                            $third->save([
                                'access_token' => $json['session_key'],
                                'expires_in' => 7776000,
                                'logintime' => $time,
                                'expiretime' => $time + 7776000
                            ]);
                            $ret = $this->auth->direct($user->id);
                            if ($ret) {
                			    if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weixin_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $json['session_key'];
                            $third->expires_in  = 7776000;
                            $third->logintime  = $time;
                            $third->expiretime  = $time + 7776000;
                            // 判斷當前是否登录
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自动完成
                                $this->success('綁定成功', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
                        }
					}else{
						$this->error('API异常，微信小程序登录失敗'); 
					}
					break;
					
				// 微信App登录
				case 'app_weixin':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token'],
						'openid' => $post['loginData']['authResult']['openid']
					];
					$result = Http::sendRequest("https://api.weixin.qq.com/sns/userinfo", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weixin_open', 'openid' => $json['openid']]);
						}
					    // 成功登录
                        if ($third) {
                            $third->save([
                                'access_token' => $post['loginData']['authResult']['access_token'],
                                'refresh_token' => $post['loginData']['authResult']['refresh_token'],
                                'expires_in' => $post['loginData']['authResult']['expires_in'],
                                'logintime' => $time,
                                'expiretime' => $time + $post['loginData']['authResult']['expires_in']
                            ]);
                            $ret = $this->auth->direct($third['user_id']);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weixin_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $post['loginData']['authResult']['access_token'];
                            $third->refresh_token  = $post['loginData']['authResult']['refresh_token'];
                            $third->expires_in  = $post['loginData']['authResult']['expires_in'];
                            $third->logintime  = $time;
                            $third->expiretime  = $time + $post['loginData']['authResult']['expires_in'];
                            // 判斷當前是否登录,否則注冊
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自动完成
                                $this->success('綁定成功', [
                                    'binding' => 1
                                ]);
                            } else {
                                $username = $json['nickname'];
                                $mobile = '';
                                $gender = $json['sex']==1 ? 1 : 0;
                                $avatar = $json['headimgurl'];
                                // 注冊賬戶        
                                $result = $this->auth->register('u_'.Random::alnum(6), Random::alnum(), '', $mobile, [
                    		        'gender' => $gender, 
                    		        'nickname' => $username, 
                    		        'avatar' => $avatar
                    		    ]);
                    			if ($result) {
                    			    if (isset($post['client_id']) && $post['client_id'] != null) {
                        		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                        		    }
                    				$data = [
                    					'userinfo' => $this->auth->getUserinfo(),
                    					'statistics' => $this->statistics()
                    				];
                    				// 更新第三方登录
                    			    $third->user_id  = $this->auth->id;
                    			    $third->openname  = $username;
                    			    $third->save();
                    				$this->success(__('Sign up successful'), $data);
                    			} else {
                    				$this->error($this->auth->getError());
                    			}
                            }
                        }
					}else{
					    $this->error('API异常，App登录失敗'); 
					}
					break;
					
				// 微信公眾号登录
				case 'h5_weixin':
					// 后续版本上线
					break;
					
				// QQ小程序登录
				case 'mp_qq':
					$params = [
						'appid'      => $config[$platform]['appid'],
						'secret'     => $config[$platform]['appsecret'],
						'js_code'    => $post['loginData']['code'],
						'grant_type' => 'authorization_code'
					];
					$result = Http::sendRequest("https://api.q.qq.com/sns/jscode2session", $params, 'GET');
					if ($result['ret']) {
					    $json = (array)json_decode($result['msg'], true);
						if(isset($json['unionid'])){
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'unionid' => $json['unionid']]);
						}else{
							$third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'openid' => $json['openid']]);
						}
                        // 成功登录
                        if ($third) {
                            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
                            $third->save([
                                'access_token' => $json['session_key'],
                                'expires_in' => 7776000,
                                'logintime' => $time,
                                'expiretime' => $time + 7776000
                            ]);
                            $ret = $this->auth->direct($user->id);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
                        } else {
                            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'qq_open';
							if(isset($json['unionid'])){
								$third->unionid  = $json['unionid'];
							}else{
								$third->openid  = $json['openid'];
							}
                            $third->access_token  = $json['session_key'];
                            $third->expires_in  = 7776000;
                            $third->logintime  = $time;
                            $third->expiretime  = $time + 7776000;
                            // 判斷當前是否登录
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自动完成
                                $this->success('綁定成功', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
                        }
					}else{
						$this->error('API异常，微信小程序登录失敗'); 
					}
					break; 
					
				// QQ App登录
				case 'app_qq':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token']
					];
					$options = [
                        CURLOPT_HTTPHEADER  => [
                            'Content-Type: application/x-www-form-urlencoded'
                        ]
                    ];
					$result = Http::sendRequest("https://graph.qq.com/oauth2.0/me", $params, 'GET' ,$options);
					if ($result['ret']) {
					    $json = (array)json_decode(str_replace(" );","",str_replace("callback( ","",$result['msg'])), true);
					    if ($json['openid'] == $post['loginData']['authResult']['openid']) {
				            $third = model('app\api\model\wanlshop\Third')->get(['platform' => 'qq_open', 'openid' => $json['openid']]);
    				        if ($third) {
    				            $user = model('app\common\model\User')->get($third['user_id']);
                                if (!$user) {
                                    $this->success('尚未綁定用戶', [
                                        'binding' => 0,
                                        'third_id' => $third['id']
                                    ]);
                                }
    				            $third->save([
                                    'access_token' => $post['loginData']['authResult']['access_token'],
                                    'expires_in' => $post['loginData']['authResult']['expires_in'],
                                    'logintime' => $time,
                                    'expiretime' => $time + $post['loginData']['authResult']['expires_in']
                                ]);
                                $ret = $this->auth->direct($third['user_id']);
                                if ($ret) {
                                    if (isset($post['client_id']) && $post['client_id'] != null) {
                        		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                        		    }
                    				$data = [
                    					'userinfo' => $this->auth->getUserinfo(),
                    					'statistics' => $this->statistics()
                    				];
                    				$this->success(__('Sign up successful'), $data);
                    			} else {
                    				$this->error($this->auth->getError());
                    			}
    				        } else {
    				            // 新增$third
                                $third = model('app\api\model\wanlshop\Third');
                                $third->platform  = 'qq_open';
                                $third->openid  = $json['openid'];
                                $third->access_token  = $post['loginData']['authResult']['access_token'];
                                $third->expires_in  = $post['loginData']['authResult']['expires_in'];
                                $third->logintime  = $time;
                                $third->expiretime  = $time + $post['loginData']['authResult']['expires_in'];
                                // 判斷當前是否登录
                                if($this->auth->isLogin()){
                                    $third->user_id  = $this->auth->id;
                                    $third->save();
                                    // 直接綁定自动完成
                                    $this->success('綁定成功', [
                                        'binding' => 1
                                    ]);
                                } else {
                                    $third->save();
                                    // 通知客戶端綁定
                                    $this->success('尚未綁定用戶', [
                                        'binding' => 0,
                                        'third_id' => $third->id
                                    ]);
                                }
    				        }
					    } else {
					        $this->error(__('非法请求，机器信息已提交'));
					    }
					}else{
					    $this->error('API异常，App登录失敗'); 
					}
					break;
				// QQ 網页登录
				case 'h5_qq':
					// 后续版本上线
					break; 
				// 微博App登录
				case 'app_weibo':
					$params = [
						'access_token' => $post['loginData']['authResult']['access_token']
					];
					$options = [
                        CURLOPT_HTTPHEADER  => [
                            'Content-Type: application/x-www-form-urlencoded'
                        ],
                        CURLOPT_POSTFIELDS => http_build_query($params),
                        CURLOPT_POST => 1
                    ];
					$result = Http::post("https://api.weibo.com/oauth2/get_token_info", $params, $options);
					$json = (array)json_decode($result, true);
				    if($json['uid'] == $post['loginData']['authResult']['uid']){
				        $third = model('app\api\model\wanlshop\Third')->get(['platform' => 'weibo_open', 'openid' => $json['uid']]);
				        if ($third) {
				            $user = model('app\common\model\User')->get($third['user_id']);
                            if (!$user) {
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third['id']
                                ]);
                            }
				            $third->save([
                                'access_token' => $post['loginData']['authResult']['access_token'],
                                'expires_in' => $json['expire_in'],
                                'logintime' => $json['create_at'],
                                'expiretime' => $json['create_at'] + $json['expire_in']
                            ]);
                            $ret = $this->auth->direct($third['user_id']);
                            if ($ret) {
                                if (isset($post['client_id']) && $post['client_id'] != null) {
                    		        $this->wanlchat->bind($post['client_id'], $this->auth->id);
                    		    }
                				$data = [
                					'userinfo' => $this->auth->getUserinfo(),
                					'statistics' => $this->statistics()
                				];
                				$this->success(__('Sign up successful'), $data);
                			} else {
                				$this->error($this->auth->getError());
                			}
				        } else {
				            // 新增$third
                            $third = model('app\api\model\wanlshop\Third');
                            $third->platform  = 'weibo_open';
                            $third->openid  = $json['uid'];
                            $third->access_token  = $post['loginData']['authResult']['access_token'];
                            $third->expires_in  = $json['expire_in'];
                            $third->logintime  = $json['create_at'];
                            $third->expiretime  = $json['create_at'] + $json['expire_in'];
                            // 判斷當前是否登录
                            if($this->auth->isLogin()){
                                $third->user_id  = $this->auth->id;
                                $third->save();
                                // 直接綁定自动完成
                                $this->success('綁定成功', [
                                    'binding' => 1
                                ]);
                            } else {
                                $third->save();
                                // 通知客戶端綁定
                                $this->success('尚未綁定用戶', [
                                    'binding' => 0,
                                    'third_id' => $third->id
                                ]);
                            }
				        }
				    }else{
				        $this->error(__('非法请求，机器信息已提交'));
				    }
					break; 
					
				// 小米App登录
				case 'app_xiaomi':
					
					break;
					
				// 蘋果登录
				case 'apple':
					// 后续版本上线
					break; 
				default:
					$this->error('暫並不支持此方法登录');
			}
		}
		$this->error(__('10086非正常请求'));
    }

    /**
	 * 進一步完善资料
	 * @ApiMethod   (POST)
	 */
	public function perfect()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
		    $post = $this->request->post();
		    // 判斷third_id沒有綁定
		    $third = model('app\api\model\wanlshop\Third')->get($post['third_id']);
		        // 當user_id 不为空可以綁定
    		    if($third['user_id'] == 0 && $third){
    		        $username = $post['nickName'];
    		        $mobile = '';
    		        $gender = $post['gender'];
        		    $avatar = $post['avatarUrl'];
        		    $result = $this->auth->register('u_'.Random::alnum(6), Random::alnum(), '', $mobile, [
        		        'gender' => $gender, 
        		        'nickname' => $username, 
        		        'avatar' => $avatar
        		    ]);
        			if ($result) {
        				$data = [
        					'userinfo' => $this->auth->getUserinfo(),
        					'statistics' => $this->statistics()
        				];
        				// 更新第三方登录
        				$third->save([
        			        'user_id' => $this->auth->id,
        			        'openname' => $username
        			    ]);
        				$this->success(__('Sign up successful'), $data);
        			} else {
        				$this->error($this->auth->getError());
        			}
    		    }else{
    		        $this->error(__('非法请求，机器信息已提交'));
    		    }
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 刷新用戶中心
	 * @ApiMethod   (POST)
	 */
	public function refresh()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$this->success(__('刷新成功'), $this->statistics());
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 数据統计 - 內部使用，开发者不要調用
	 */
	public function statistics()
	{
		$user_id = $this->auth->id;
		// 查詢订单
		$order = model('app\api\model\wanlshop\Order')
			->where('user_id', $user_id)
			->select();
		$orderCount = array_count_values(array_column($order,'state'));
		// 物流列表
		$logistics = [];
		foreach ($order as $value)
		{
			if($value['state'] >=3 && $value['state'] <=6){
				//需要查詢的订单
			}
		}
		// 查詢动态 、收藏夾、关注店铺、足跡、紅包卡券
		$data = [
			'dynamic' => [
				'collection' => model('app\api\model\wanlshop\GoodsFollow')->where('user_id', $user_id)->count(),
				'concern' => model('app\api\model\wanlshop\ShopFollow')->where('user_id', $user_id)->count(),
				'footprint' => model('app\api\model\wanlshop\Record')->where('user_id', $user_id)->count(),
				'coupon' => model('app\api\model\wanlshop\CouponReceive')->where(['user_id' => $user_id, 'state' => '1'])->count(),
				'accountbank' => model('app\api\model\wanlshop\PayAccount')->where('user_id', $user_id)->count()
			],
			'order' => [
				'pay' => isset($orderCount[1]) ? $orderCount[1] : 0,
				'delive' => isset($orderCount[2]) ? $orderCount[2] : 0,
				'receiving' => isset($orderCount[3]) ? $orderCount[3] : 0,
				'evaluate' => isset($orderCount[4]) ? $orderCount[4] : 0,
				'customer' => model('app\api\model\wanlshop\Refund')->where(['state' => ['in','1,2,3,6'], 'user_id' => $this->auth->id])->count()
			],
			'logistics' => $logistics
		];
	    return $data;
	}
	
	/**
	 * 獲取评论列表
	 *
	 * @ApiSummary  (WanlShop 獲取我的所有评论)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $list_rows  每页数量
	 * @param string $page  當前页
	 */
	public function comment()
	{
		$list = model('app\api\model\wanlshop\GoodsComment')
			->where('user_id', $this->auth->id)
			->field('id,images,score,goods_id,order_goods_id,state,content,createtime')
			->order('createtime desc')
			->paginate()
			->each(function($data, $key){
				$data['order_goods'] = $data->order_goods ? $data->order_goods->visible(['id','title','image','price']):'';
				return $data;
			});
		$this->success('返回成功', $list);
	}
	
	/**
	 * 獲取积分明細
	 */
	public function scoreLog()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\common\model\ScoreLog')
				->where('user_id', $this->auth->id)
				->order('createtime desc')
				->paginate();
			$this->success('ok',$list);
		}
		$this->error(__('非法请求'));
	}
	
}