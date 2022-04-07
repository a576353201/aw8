<?php
// 2020年2月18日18:16:41
// 修改 2020年7月26日06:55:45

// 修改 2020年11月22日18:36:01
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use fast\Http;
use OSS\Core\OssException;
use OSS\OssClient;
use fast\Random;

use fast\Tree;
use think\Config;
use think\Db;
use think\Hook;

/**
 * WanlShop公共接口
 */
class Common extends Api
{
    protected $noNeedLogin = ['init','search','update','adverts','searchList','setSearch','about','fy','up_stock'];
	protected $noNeedRight = ['*'];

    public function up_stock()
    {
        $list = Db::query("update fa_wanlshop_wholesale_sku set stock=FLOOR(89+RAND()*5000) where stock<20");
        $list = Db::query("update fa_wanlshop_goods_sku set stock=FLOOR(89+RAND()*5000) where stock=0");


        $dd=2;
        $dd=1;
    }
    public function fy()
    {

        $appid='20210829000929967';
        $my='nBOic25Fv5Bbbp6SWj9Q';



        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i <9; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        $q='apple';
//        $from='en';
//        $to='cht';//cht
        $to='en';
        $from='cht';//cht



        $list = Db::name('wanlshop_category')->where(['type' => 'goods'])->whereNull('cname')->order('weigh desc,id desc')->select();


        foreach ($list as &$vv) {
            $q=$vv['name'];
            mt_srand(10000000*(double)microtime());
            for ($i = 0, $str = '', $lc = strlen($chars)-1; $i <9; $i++){
                $str .= $chars[mt_rand(0, $lc)];
            }

            $salt=$str;//'1435660288';

            $str1=$appid.$q.$salt.$my;
            $sign=md5($str1);
            $q=urlencode($q);
            $sign=md5($str1);
            $url='http://api.fanyi.baidu.com/api/trans/vip/translate?q='.$q.'&from='.$from.'&to='.$to.'&appid='.$appid.'&salt='.$salt.'&sign='.$sign;
            $result = Http::sendRequest($url, [], 'GET');
            // sleep(3);
            $json=json_decode($result['msg']);

            if(isset($json->trans_result)&&is_object($json->trans_result[0])) {
                $cname=$json->trans_result[0]->dst;
                Db::name('wanlshop_category')->where(['id' => $vv['id']])->update(['ename' => $cname]);
            }

            //model('app\api\model\antshop\CouponReceive')->where(['id' => $order['coupon_id']])->update(['state' => 1]);

            $dd=1;

        }

        $list = Db::name('wanlshop_category')->where(['type' => 'goods'])->whereNull('ename')->order('weigh desc,id desc')->select();
        if($list){
            header('Location:http://127.0.0.1:89/api/wanlshop/common/fy' );
            $dd=1;
            $dd=1;
            exit;
        }




        $dd=1;
    }
	/**
	 * 壹次性加載App
	 *
	 * @ApiSummary  (WanlShop 獲取首頁、購物車、類目數據)
	 * @ApiMethod   (GET)
	 *
	 */
    public function init()
    {

        header('Content-type: application/json;charset=utf-8');

        // 首頁
		$homeList = model('app\api\model\wanlshop\Page')
			->where('type','index')
			->field('page, item')
			->find();			
		if(!$homeList){
			$this->error(__('尚未添加首頁，請到後臺【頁面管理】添加首頁'));
		}
		// 類目
		$tree = Tree::instance();
		$tree->init(model('app\api\model\wanlshop\Category')->where(['type' => 'goods', 'isnav' => 1])->field('id, pid, name, image')->order('weigh asc')->select());
		// 搜索關鍵字
		$searchList = model('app\api\model\wanlshop\Search')
			->where(['flag' => 'index'])
			->field('keywords')
			->order('views desc')
			->limit(10)
		    ->select();
		// 獲取配置
		$config = get_addon_config('wanlshop');
		// 壹次性獲取模塊
		$modulesData  = [
			"homeModules" => $homeList,
			"categoryModules" => $tree->getTreeArray(0),//$tree->genTree($tree->arr),
			"searchModules" => $searchList
		];
		// 追加h5地址用於分享二維碼等
		$config['config']['domain'] = $config['h5']['domain'].($config['h5']['router_mode'] == 'hash' ? '/#':'');
		// 輸出
		$this->success('返回成功', [
			"modulesData" => $modulesData,
			"appStyle" => $config['style'],
			"appConfig" => $config['config'],
			"serviceVersion" => '202006183294701'  //數據版本號必須是整數
		]);
    }
	
	/**
	 * APP熱更新 1.0.3升級
	 *
	 * @ApiSummary  (WanlShop APP熱更新)
	 * @ApiMethod   (GET)
	 *
	 */
	public function update()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$row = model('app\api\model\wanlshop\Version')
			->order('versionCode desc')
			->find();

		$this->success('返回成功', $row);	
	}
	
	
	
	/**
	 * 加載廣告
	 *
	 * @ApiSummary  (WanlShop 加載廣告)
	 * @ApiMethod   (GET)
	 *
	 */
	public function adverts()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$data = [
			'openAdverts' => [],
			'pageAdverts' => [],
			'categoryAdverts' => [],
			'firstAdverts' => [],
			'otherAdverts' => []
		];
		$list = model('app\api\model\wanlshop\Advert')
			->field('id,category_id,media,module,type,url')
			->select();
		foreach ($list as $value) {
			$category_id = $value['category_id'];
			unset($value['category_id']);
			if($value['module'] == 'open'){
				$openData[] = $value;
				$data['openAdverts'] = $openData[array_rand($openData,1)];
			}
			if($value['module'] == 'page'){
				$data['pageAdverts'][] = $value;
			}
			if($value['module'] == 'category'){
				$data['categoryAdverts'][$category_id][] = $value;
			}
			if($value['module'] == 'first'){
				$data['firstAdverts'][] = $value;
			}
			if($value['module'] == 'other'){
				$data['otherAdverts'][] = $value;
			}
		}
		// 通過大版本號查詢，對應數據，未來版本升級開發
		$version = $this->request->request("version", '');
		$this->success('返回成功', ['data' => $data,'version' => $version]);	
	}
	
	/**
	 * 熱門搜索
	 *
	 * @ApiSummary  (WanlShop 搜索關鍵詞列表)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function searchList()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$list = model('app\api\model\wanlshop\Search')
			->field('id,keywords,flag')
			->order('views desc')
			->limit(20)
		    ->select();
		$this->success('返回成功', $list);	
	}
	
	/**
	 * 提交搜索關鍵字給系統
	 *
	 * @ApiSummary  (WanlShop 搜索關鍵詞列表)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $keywords 關鍵字
	 */
	public function setSearch()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		$keywords = $this->request->request("keywords", '');
		$model = model('app\api\model\wanlshop\Search');
		if($model->where('keywords',$keywords)->count() > 0){
			$model->where('keywords',$keywords)->setInc('views');
		}else{
			$model->save(['keywords'=>$keywords]);
		}
		$this->success('返回成功');	
	}
	
	
	
    /**
     * 實時搜索類目&相關類目
     *
     * @ApiSummary  (WanlShop 搜索關鍵詞列表)
     * @ApiMethod   (GET)
     * 
	 * @param string $search 搜索內容
     */
    public function search()
    {
    	//設置過濾方法
    	$this->request->filter(['strip_tags']);
		$search = $this->request->request('search', '');
		if($search){
			// 查詢相關類目
			$categoryList = model('app\api\model\wanlshop\Category')
			    ->where('name','like','%'.$search.'%')
				->field('id,name')
				->limit(20)
			    ->select();
				
			// 查詢搜索數據
			$searchList = model('app\api\model\wanlshop\Search')
			    ->where('keywords','like','%'.$search.'%')
				->field('keywords')
				->limit(20)
			    ->select();
			$result = array("categoryList" => $categoryList, "searchList" => $searchList);
			$this->success('返回成功', $result);	
		}else{
			$this->success('請輸入關鍵字');
		}
    }
    
	
	
	/**
	 * 二維碼配置
	 *
	 * @ApiSummary  (WanlShop 查詢二維碼配置)
	 * @ApiMethod   (POST)
	 *
	 */
	public function qrcode()
	{
		//設置過濾方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isPost()) {
			$list = model('app\api\model\wanlshop\Qrcode')
				->field('id,name,template,canvas_width,canvas_height,thumbnail_width,thumbnail_url,background_url,logo_src,checked,status')
				->order('weigh desc')
				->select();
		    $list[0]['luodiurl'] = Config::get('site.luodiurl');
			$this->success('返回成功', $list);	
		}
		$this->error(__('非正常訪問'));
	}

	

	

	/**

	 * 關於系統

	 *

	 * @ApiSummary  (WanlShop 關於系統)

	 * @ApiMethod   (GET)

	 *

	 */

	public function about()

	{

		$config = get_addon_config('wanlshop');

		$this->success('返回成功', [

			'name' => $config['ini']['name'],

			'logo' => $config['ini']['logo'],

			'copyright' => $config['ini']['copyright']

		]);	

	}

	

	/**

	 * 獲取上傳配置 1.0.2升級

	 *

	 * @ApiSummary  (WanlShop 上傳配置)

	 * @ApiMethod   (GET)

	 *

	 */

	public function uploadData()

	{

		//配置信息

		$upload = Config::get('upload');

		//如果非服務端中轉模式需要修改為中轉

		if ($upload['storage'] != 'local' && isset($upload['uploadmode']) && $upload['uploadmode'] != 'server') {

		    //臨時修改上傳模式為服務端中轉

		    set_addon_config($upload['storage'], ["uploadmode" => "server"], false);

		

		    $upload = \app\common\model\Config::upload();

		    // 上傳信息配置後

		    Hook::listen("upload_config_init", $upload);

		

		    $upload = Config::set('upload', array_merge(Config::get('upload'), $upload));

		}

		$upload['cdnurl'] = $upload['cdnurl'] ? $upload['cdnurl'] : cdnurl('', true);

		$upload['uploadurl'] = preg_match("/^((?:[a-z]+:)?\/\/)(.*)/i", $upload['uploadurl']) ? $upload['uploadurl'] : url($upload['storage'] == 'local' ? '/api/common/upload' : $upload['uploadurl'], '', false, true);

		$this->success('返回成功', $upload);

	}
}
