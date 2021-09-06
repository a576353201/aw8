<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use addons\wanlshop\library\WanlChat\WanlChat;
use think\Session;
use think\Db;
/**
 * WanlShop即時通讯接口
 */
class Chat extends Api
{
    protected $noNeedLogin = ['shake','service','hello','state'];
	protected $noNeedRight = ['*'];
    

    public function _initialize()
    {
        parent::_initialize();
		//WanlChat 即時通讯調用
		$this->wanlchat = new WanlChat();
		// 調用配置
		$this->chatConfig = get_addon_config('wanlshop');

    }
    
    /**
     * 綁定UID
     *
	 * @ApiSummary  (WanlChat 綁定UID)
	 * @ApiMethod   (POST)
	 *
     * @param string $client_id 
     */
    public function shake()
    {
        //设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$client_id = $this->request->post('client_id');
			$client_id?'':($this->error(__('Invalid parameters')));
			// 綁定在线
			if ($this->auth->isLogin()) {
			    $user_id = $this->auth->id;
			    // 查詢有沒有綁定其他如果有的话全部解綁，退出登录页執行此操作
			    foreach ($this->wanlchat->getUidToClientId($user_id) as $client_id_old) {
			    	$this->wanlchat->unbind($client_id_old, $user_id);
			    }
			    // 重新綁定壹个新的
			    $this->wanlchat->bind($client_id, $user_id);
			    // 查詢是否有離线消息
				$list = model('app\api\model\wanlshop\Chat')
					->where(['to_id' => $user_id, 'online' => 0, 'type' => 'chat'])
					->whereTime('createtime', 'week')
					->field('id,form_uid,to_id,form,message,type,online,createtime')
					->select();
				foreach($list as $message){
					$this->wanlchat->send($user_id, $message);
					model('app\api\model\wanlshop\Chat')->save(['online' => 1], ['id' => $message['id']]);
				}
				$this->success(__('即時通讯初始化成功'), $client_id);
			}else{
			    // 綁定離线，可能用戶在线客服等其他消息通知
			    
			    $this->success(__('即時通讯離线初始化成功'), $client_id);
			}
		}
		$this->error(__('非正常请求'));
    }
    
	/**
	 * 聊天列表
	 *
	 * @ApiSummary  (WanlChat 讀取聊天列表)
	 * @ApiMethod   (GET)
	 */
	public function lists()
	{
		$user_id = $this->auth->id;
		$list = [];
		$sub = Db::name('WanlshopChat')
			->where(['type' => 'chat'])
			->order('createtime', 'desc')
		    ->field('to_id as uid, message, isread, type, createtime')
		    ->where('form_uid ='.$user_id)
		    ->union('SELECT form_uid as uid, message, isread, type, createtime FROM '.config('database.prefix').'wanlshop_chat WHERE to_id = '.$user_id)
			->buildSql();
		$query = Db::table($sub)
			->alias('temp')
			->group('temp.uid')
			->select();
		foreach($query as $row)
		{
			if($row['type'] == 'chat'){ //臨時
				$shop = model('app\api\model\wanlshop\Shop')
					->where(['user_id' => $row['uid']])
					->find();
				// 統计未讀
				$count = model('app\api\model\wanlshop\Chat')
					->where(['form_uid' => $shop['user_id'], 'to_id' => $user_id, 'isread' => 0])
					->count();
				
				$content = json_decode($row['message'], true);
				// 轉換为文字消息 1.0.2升級
				if($content['type'] == 'img'){

					$msgtext = '[picture message]';

				}else if($content['type'] == 'voice'){

					$msgtext = '[voice message]';

				}else if($content['type'] == 'goods'){

					$msgtext = '[commodity news]';

				}else if($content['type'] == 'order'){

					$msgtext = '[order message]';

				}else if($content['type'] == 'text'){

					$msgtext = $content['content']['text'];

				}else{

					$msgtext = '[unknown message type]';

				}
				// 输出
				$list[] = [
					'id' => $shop['id'],
					'user_id' => $shop['user_id'],
					'name' => $shop['shopname'],
					'avatar' => $shop['avatar'],
					'content' => $msgtext,
					'count' => $count,
					'createtime' => $row['createtime']
				];
			}
		}
		$this->success(__('OK'),$list);
	}

	/**
	 * 发送消息
	 *
	 * @ApiSummary  (WanlChat 发送即使消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $message 消息內容JSON
	 */
	public function send()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){

			// 判斷服务是否啟动

			if(!$this->wanlchat->isWsStart()){

				$this->error('please start im instant messaging service');

			}
			$message = $this->request->post();
			$message['type'] = 'chat'; //用戶唯壹发送口，加chat防止偽裝客服或其他类型消息
			$message?'':($this->error(__('Invalid parameters')));
			if($message['form']['id'] != $this->auth->id){
				$this->error(__('非法访问'));
			}
			// 判斷是否为自己
			if($message['form']['id'] == $message['to_id']){
				$this->error(__('don t allow yourself to chat with yourself'));
			}
			// 查詢是否在线
			$online = $this->wanlchat->isOnline($message['to_id']);

			// 保存聊天条到服务器
			$data = model('app\api\model\wanlshop\Chat');
			$data->form_uid = $message['form']['id'];
			$data->to_id = $message['to_id'];
			$data->form = json_encode($message['form']);
			$data->message = json_encode($message['message']);
			$data->type = $message['type'];
			$data->online = $online;
			$data->save();
			$message['id'] = $data->id;
			// 在线发送
			$online == 1 ? ($this->wanlchat->send($message['to_id'], $message)) : '';
			$this->success(__('sent successfully'), []);
		}
		$this->error(__('非法请求'));
	}
	

	/**

	 * 查詢IM服务器狀态

	 *

	 * @ApiSummary  (WanlChat 查詢用戶历史消息)

	 * @ApiMethod   (GET)

	 */

	public function state()

	{

		if(!$this->wanlchat->isWsStart()){

			$this->error('IM 服务器未啟动，请通知管理員查看，直播服务登录服务暫停');

		}else{

			$this->success(__('IM服务器已啟动'));

		}

	}

	

	
	/**
	 * 查詢用戶聊天条
	 *
	 * @ApiSummary  (WanlChat 查詢用戶历史消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $to_id 接受ID
	 */
	public function history()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('to_id');
			$id?'':($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 查詢历史条
			$result = model('app\api\model\wanlshop\Chat')
				->where("((form_uid={$uid} and to_id={$id}) or (form_uid={$id} and to_id={$uid})) and type='chat'")
				->whereTime('createtime', 'month')
				->order('createtime Desc')
				->paginate();
			$this->success(__('发送成功'), $result);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 全部已讀
	 *
	 * @ApiSummary  (WanlChat 已讀店铺消息)
	 * @ApiMethod   (POST)
	 */
	public function read()
	{
		if($this->request->isPost()){
			$uid = $this->auth->id;
			$data = model('app\api\model\wanlshop\Chat')
				->where(['to_id' => $uid, 'isread' => 0, 'type' => 'chat'])
				->update(['isread' => 1]);	
			$this->success(__('更新成功'), []);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 已讀店铺消息
	 *
	 * @ApiSummary  (WanlChat 已讀店铺消息)
	 * @ApiMethod   (POST)
	 *
	 * @param string $shop_id 店铺ID
	 */
	public function clear()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('id');
			$id?'':($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 设置成已讀
			$data = model('app\api\model\wanlshop\Chat')
				->where(['form_uid' => $id, 'to_id' => $uid, 'isread' => 0])
				->update(['isread' => 1]);	
			$this->success(__('更新成功'), $data);
		}
		$this->error(__('非法请求'));
	}
	
	/**
	 * 刪除指定聊天条
	 *
	 * @ApiSummary  (WanlChat 刪除指定聊天条)
	 * @ApiMethod   (POST)
	 *
	 * @param string $shop_id 店铺ID
	 */
	public function del()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$id = $this->request->post('id');
			$id ? '' : ($this->error(__('Invalid parameters')));
			$uid = $this->auth->id;
			// 设置成已讀
			$data = model('app\api\model\wanlshop\Chat')
				->where("((form_uid={$uid} and to_id={$id}) or (form_uid={$id} and to_id={$uid})) and type='chat'")
				->delete();
			$this->success(__('更新成功'), $data);
		}
		$this->error(__('非法请求'));
	}
	

	/**

	 * 加载歡迎消息 1.0.2升級

	 *

	 * @ApiSummary  (WanlChat 加载歡迎消息)

	 * @ApiMethod   (POST)

	 */

	public function hello()

	{

		//设置过濾方法

		$this->request->filter(['strip_tags']);

		if($this->request->isPost()){

			$post = $this->request->post();

			if($post['type'] == 'service'){

				$data['id'] = $post['id'] + 1;

				$data['type'] = 'service';

				$data['form']['id'] = 0;

				$data['message']['type'] = 'text'; //默认消息

				$data['message']['content']['text'] = $this->chatConfig['config']['auth_reply'];

				$data['createtime'] = time();

				$this->wanlchat->send($post['form_id'], $data);

			}else if($post['type'] == 'shop'){

				

			}

			$this->success(__('请求成功'));

		}

		$this->error(__('非法请求'));

	}

	

	
	/**
	 * 智能小秘
	 *
	 * @ApiSummary  (WanlChat 智能小秘)
	 * @ApiMethod   (POST)
	 */
	public function service()
	{
		//设置过濾方法
		$this->request->filter(['strip_tags']);
		if($this->request->isPost()){
			$post = $this->request->post();
			$form_id = $post['form']['id'];
			if($post['message']['type'] == 'text'){
				$content = $post['message']['content']['text'];
			}
			$data['id'] = $post['id'] + 1;
			$data['type'] = 'service';
			$data['form']['id'] = 0;
			$data['message']['type'] = 'text'; //默认消息
			$data['createtime'] = time();
			if($post['to_id'] == 0){
				if($post['message']['type'] == 'text'){
					if($content == '人工客服' || $content == '客服' || $content == '人工'){
						// 查詢 哪个后台在线
						$online = [];
						$admin = model('app\api\model\wanlshop\Admin')
							->field('id,nickname,avatar')
							->select();

						foreach($admin as $user){
							if($this->wanlchat->isOnline(bcadd(8080000,$user['id'])) == 1){
								 $online[] = $user;
							}
						}

						if(count($online) == 0){
							$data['message']['content']['text'] = $this->chatConfig['config']['not_online'];
						}else{
							$key = mt_rand(0,count($online)-1);
							$data['form']['id'] = bcadd(8080000, $online[$key]['id']); // 随机发送壹个在线管理員
							$data['form']['name'] = $online[$key]['nickname'];
							$data['form']['avatar'] = $online[$key]['avatar'];
							$data['message']['content']['text'] = $this->chatConfig['config']['service_initial'];
						}
						$this->wanlchat->send($form_id, $data);
					}else{
						$list = model('app\api\model\wanlshop\Article')
							->where('keywords',$content)
							->field('id,title,content')
							->find();
						if($list){
							$data['message']['type'] = 'article';
							$data['message']['content'] = $list;
						}else{
							$arr = explode(' ',$content);
							$like = [];
							foreach($arr as $value){
								$like[] = '%'.$value.'%';
							}
							$article = model('app\api\model\wanlshop\Article')
								->where('title|content','like',$like,'OR')
								->field('id,title,keywords')
								->select();
							$data['message']['type'] = 'list';
							$data['message']['content'] = $article;
						}
						$this->wanlchat->send($form_id, $data);
					}
				}else{
					if($post['message']['type'] == 'img'){
						$type = '圖片消息';
					}
					if($post['message']['type'] == 'voice'){
						$type = '語音消息';
					}
					$data['message']['content']['text'] = '[可憐][委屈][委屈]，智能小秘暫无法識別“'.$type.'”，您可以与人工客服溝通時可以使用~~';
					$this->wanlchat->send($form_id, $data);
				}
			}else{
				$online = 1;
				// 保存聊天条到服务器
				$data = model('app\api\model\wanlshop\Chat');
				$data->form_uid = $post['form']['id'];
				$data->to_id = $post['to_id'];
				$data->form = json_encode($post['form']);
				$data->message = json_encode($post['message']);
				$data->type = $post['type'];
				$data->online = $online;
				$data->save();
				$post['id'] = $data->id;
				// 在线发送
				$this->wanlchat->send($post['to_id'], $post);
			}
			$this->success(__('请求成功'));
		}
		$this->error(__('非法请求'));
	}
}
