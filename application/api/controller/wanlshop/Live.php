<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use fast\Random;
use addons\wanlshop\library\Alilive;
use addons\wanlshop\library\WanlChat\WanlChat;

/**
 * WanlShop 发现接口
 */
class Live extends Api
{
    protected $noNeedLogin = ['play'];
	protected $noNeedRight = ['*'];
    
	public function _initialize()
	{
	    parent::_initialize();
		$this->wanlchat = new WanlChat();
		if(!$this->wanlchat->isWsStart()){
			$this->error(__('即時通讯服务未啟动'));
		}
	    $this->model = new \app\api\model\wanlshop\Live;
	}
	
	/**

	 * 查詢直播權限 1.0.2升級 添加isself

	 */

	public function live()

	{

		$shop = model('app\api\model\wanlshop\Shop')

			->where(['user_id' => $this->auth->id])

			->field('id,avatar,shopname,islive,isself')

			->find();

		if($shop){

			$shop['islive'] == 1 ? $this->success('返回成功', $shop) : $this->error(__('妳還沒有直播權限，请联系客服申请！'));

		}else{

			$this->error(__('您還不是商家，沒有直播權限'));

		}

	}
	
	/**
	 * 添加並开始直播
	 *
	 * 接受到直播回調在自动，发布动态
	 */
	public function startLive()
	{
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$post = $this->request->post();
			$user_id = $this->auth->id;
			$shop = model('app\api\model\wanlshop\Shop')
				->where(['user_id' => $user_id])
				->find();
			if($shop){
				$random = Random::alnum(16);
				$config = get_addon_config('wanlshop');
				$alilive = new Alilive($config['live']['liveDomain'], $config['live']['pushDomain'], $config['live']['builderTime'], $config['live']['pushKey'], $config['live']['liveKey'], $config['live']['appName'], $random, $shop['id'], $config['live']['transTemplate']);
				$alilive = $alilive->urlBuilder();
				// 添加直播
				$live = $this->model;
				$live->shop_id = $shop['id'];
				$live->image = $post['image'];
				$live->content = $post['content'];
				$live->goods_ids = $post['goods_ids'];
				$live->liveid = $random;
				$live->liveurl = $alilive['rtmpurl'].','.$alilive['m3u8url'];
				$live->pushurl = $alilive['pushurl'];
				$live->save();
				// 創建壹个群组將我加入進去
				foreach ($this->wanlchat->getUidToClientId($user_id) as $client_id) {
					$this->wanlchat->joinGroup($client_id, $random);
				}
				$this->success('返回成功', [
					'id' => $live->id,
					'liveid' => $live->liveid,
					'pushurl' => $live->pushurl
				]);
			}else{
				$this->error(__('您還不是商家，沒有直播權限'));
			}
		}
		$this->error(__('非正常访问'));
	}
	
	/**
	 * 結束直播
	 */
	public function endLive($id = null)
	{
		$row = $this->model
			->where(['id' => $id])
			->field('id,shop_id,goods_ids,image,like,views')
			->find();
		$row['goodsnum'] = count(explode(',', $row['goods_ids']));
		$row->shop->visible(['id','avatar','shopname']);
		$this->success('返回成功', $row);
	}
	
	
	/**
	 * 直播播放页
	 */
	public function play($id = null)
	{
		$row = $this->model
			->where(['id' => $id])
			->field('id,liveid,liveurl,recordurl,state,shop_id,goods_ids,image,like')
			->find();
		$user_id = $this->auth->id;
		$follow = 0;
		// 判斷是否登录
		if($this->auth->isLogin()){
			$follow = model('app\api\model\wanlshop\ShopFollow')->where(['user_id' => $user_id, 'shop_id' => $row['shop_id']])->count();
			// 瀏览 +1
			$this->model->where(['id' => $id])->setInc('views');
			// 創建壹个群组將我加入進去
			foreach ($this->wanlchat->getUidToClientId($user_id) as $client_id) {
				$this->wanlchat->joinGroup($client_id, $row['liveid']);
			}
			// 开始廣播我進入了直播間
			$this->sendLiveGroup($row['liveid'], ['type' => 'coming']);
		}
		$row->isFollow = $follow == 0 ? false : true;
		// 獲取店铺信息
		$row->shop->visible(['id','avatar','shopname']);
		// 獲取商品信息
		$row->goods = model('app\api\model\wanlshop\Goods')
			->where('id', 'in', $row['goods_ids'])
			->field('id,image,title,price')
			->select();
		$this->success('返回成功', $row);
	}
	
	
	/**
	 * 关注商家
	 */
	public function follow($id, $group)
	{
		$this->sendLiveGroup($group, [
			'type' => 'follow',
			'text' => '关注了主播'
		]);
		$id ? $id : ($this->error(__('非正常访问')));
		$where['shop_id'] = $id;
		$where['user_id'] = $this->auth->id;
		if(model('app\api\model\wanlshop\ShopFollow')->where($where)->count() == 0){
			model('app\api\model\wanlshop\ShopFollow')->save($where);
			model('app\api\model\wanlshop\Shop')->where(['id'=>$id])->setInc('like'); //喜歡+1
			$this->success('返回成功', true);
		}else{
			model('app\api\model\wanlshop\ShopFollow')->where($where)->delete();
			model('app\api\model\wanlshop\Shop')->where(['id'=>$id])->setDec('like'); //喜歡-1
			$this->success('返回成功', false);
		}
	}
	
	/**
	 * 直播点贊 +1
	 */
	public function like($id = null)
	{
		$row = $this->model->get($id);
		// 廣播群组我点贊了
		$this->sendLiveGroup($row['liveid'], [
			'type' => 'like',
			'text' => '点了壹个贊'
		]);
		$row->setInc('like');
		$this->success('返回成功');
	}
	
	/**
	 * 发送直播消息
	 */
	public function send($group, $message)
	{
		$this->sendLiveGroup($group, [
			'type' => 'msg',
			'text' => $message
		]);
	}
	
	/**
	 * 求講解
	 */
	public function seek($group, $goods_index)
	{	
		$this->sendLiveGroup($group, [
			'type' => 'seek',
			'text' => '求講解壹下'.$goods_index.'号商品'
		]);
	}
	
	/**
	 * 卸载直播页面
	 */
	public function unload($group = null, $type = null)
	{
		// 廣播
		if($type == 'rtmp'){
			// 廣播关闭直播間
			$this->sendLiveGroup($group, ['type' => 'end']);
		}else{
			// 廣播直播間我退出了 -1
			$this->sendLiveGroup($group, ['type' => 'leave']);
		}
		
		// 判斷是否登录
		if($this->auth->isLogin()){
			if($type == 'rtmp'){
				// 解散分组
				$this->wanlchat->ungroup($group);
			}else{
				// 退出群组
				foreach ($this->wanlchat->getUidToClientId($this->auth->id) as $client_id) {
					$this->wanlchat->leaveGroup($client_id, $group);
				}
			}
		}
		$this->success('返回成功');
	}
	
	/**
	 * 獲取直播商品列表
	 */
	public function goods()
	{
		$shop = model('app\api\model\wanlshop\Shop')
			->where(['user_id' => $this->auth->id])
			->find();
			$list = [];
		if($shop){
			$list = model('app\api\model\wanlshop\Goods')
				->where(['shop_id' => $shop['id']])
				->field('id,image,title,price')
				->select();
			foreach ($list as $row) {
				$row->choose = false;
			}
		}else{
			$this->error(__('您還不是商家，沒有直播權限'));
		}
		$this->success('返回成功', $list);
	}
	
	/**
	 * 主播推送更新商品列表
	 */
	public function cloud($id = 0, $goods_ids = null)
	{
		$row = $this->model->get($id);
		if($row->save(['goods_ids'  => $goods_ids])){
			$goods = model('app\api\model\wanlshop\Goods')
				->where('id', 'in', $goods_ids)
				->field('id,title,image,price')
				->select();
			$this->sendLiveGroup($row['liveid'], [
				'type' => 'update',
				'data' => $goods
			]);
		}
		$this->success('推送成功过');
	}
	
	
	/**
	 * 发送直播群组消息
	 * 內部方法
	 */
	private function sendLiveGroup($group, $message)
	{
		// 查詢点贊数量
		$like = $this->model
			->where(['liveid' => $group])
			->find();
		$this->wanlchat->sendGroup($group, [
			'type' => 'live',
			'group' => $group,
			'form' => [
				'id' => $this->auth->id,
				'nickname' => $this->auth->nickname,
				// 'avatar' => $this->auth->avatar,
			],
			'message' => $message,
			'online' => $this->wanlchat->getUidCountByGroup($group),
			'like' => $like['like']
		]);
	}
    
}