<?php

// 2020年2月18日18:06:58

namespace app\api\controller\wanlshop;



use app\common\controller\Api;

use think\Db;

/**

 * WanlShop页面接口

 */

class Page extends Api

{

    protected $noNeedLogin = ['*'];

    protected $noNeedRight = ['*'];

    

    /**

     * 獲取APP首页

     *

     * @ApiSummary  (WanlShop 獲取自定義页面数据)

     * @ApiMethod   (GET)

     *

     * @param string $id 页面ID

     */

    public function index($id = null)

    {

		$error = __('页面不存在');

		$row = !$id ? $this->error($error) : model('app\api\model\wanlshop\Page')

			->where(['page_token' => $id])

			->field('page, item')

			->find();

		!$row ? $this->error($error) : $this->success('返回成功', $row);

    }

	/**

	 * 獲取指定文章

	 *

	 * @ApiSummary  (WanlShop 产品接口獲取文章)

	 * @ApiMethod   (GET)

	 * 

	 */

	public function article($ids = null)

	{

	    $row = model('app\api\model\wanlshop\Article')

	    	->where('id', 'in', $ids)

	    	->field('id,title,image,views,createtime')

	    	->select();

	    $this->success('ok', $row);

	}

	

	/**

	 * 獲取頭条文章

	 *

	 * @ApiSummary  (WanlShop 产品接口獲取文章)

	 * @ApiMethod   (GET)

	 * 

	 */

	public function headlines()

	{

		$config = get_addon_config('wanlshop');

	    $row = model('app\api\model\wanlshop\Article')

	    	->where([

				['EXP', Db::raw("FIND_IN_SET('index', `flag`)")],

				'category_id' => $config['config']['new_category']

			])

	    	->field('id,title,image')

	    	->limit(20)

	    	->select();

	    $this->success('ok', $row);

	}

	

	/**

	 * 獲取商品

	 *

	 * @ApiSummary  (WanlShop 产品接口獲取商品)

	 * @ApiMethod   (GET)

	 * 

	 */

	public function goods($ids = null)

	{

		$list = model('app\api\model\wanlshop\Goods')

			->where('id','in',$ids)

			->field('id,image,title,price,shop_id,comment,praise')

			->select();

		foreach($list as $row){

			$row->shop->visible(['state','shopname']);

			$row->isLive = model('app\api\model\wanlshop\Live')->where(['shop_id' => $row['shop_id'], 'state' => 1])->field('id')->find();

		}

		$this->success('ok', $list);

	}

	

	/**

	 * 獲取活动櫥窗

	 *

	 * @ApiSummary  (WanlShop 獲取活动櫥窗)

	 * @ApiMethod   (GET)

	 * 

	 */

	public function activity()

	{

		$param = $this->request->param();

		$col = [2,2,1,1,2];

		$activity = [

			'distribution' => '分销',

			'group' => '團购拼團',

			'bargain' => '砍价',

			'rush' => '限時搶购',

			'coupon' => '領券中心'

		];

		$list = [];

		foreach(json_decode(html_entity_decode($param['data']),true) as $key => $data){

			$list[] = [

				'activity' => $activity[$data['activity']],

				'color' => $data['textColor'],

				'describe' => $data['describe'],

				'tags' => $data['tags'],

				'list' => $col[$key]

			];

		}

		$this->success('ok', $list);

	}

	

	/**

	 * 獲取类目商品

	 *

	 * @ApiSummary  (WanlShop 页面接口獲取类目商品)

	 * @ApiMethod   (GET)

	 * 

	 */

	public function category()

	{

		$param = $this->request->param();

		$query = model('app\api\model\wanlshop\Goods')->orderRaw('rand()');

		// 数据樣式

		$col = [];

		switch ($param['col'])

		{

			case "col-1-2-2":

				$col = [3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-1-1_2":

				$col = [3,2,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-2-1_2":

				$col = [2,2,2,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-2-2_1":

				$col = [2,2,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-2-2-1_2":

				$col = [2,2,2,2,2,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-2-4":

				$col = [2,2,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

			case "col-2-2-4":

				$col = [2,2,2,2,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2];

				break;

		}

		// 查詢数据

		$list = [];

		foreach(json_decode(html_entity_decode($param['data']),true) as $key => $data){
            $pp = $this->getCategoryName($data['categoryId']);
			$list[] = [

				'name' => isset($pp->name)?$pp->name:'',

				'color' => $data['textColor'],

				'describe' => $data['describe'],

				'tags' => $data['tags'],

				'list' => $query->where(['category_id' => $data['categoryId']])

					->limit($col[$key])

					->field('id,image')

					->select()

			];

		}

		$this->success('ok', $list);

	}

	

	/**

	 * 獲取类目名（方法內使用）

	 *

	 * @ApiSummary  (WanlShop 獲取类目名)

	 * 

	 * @param string $id 订单ID

	 */

	private function getCategoryName($category_id = 10)

	{

		return model('app\api\model\wanlshop\Category')->get($category_id);

	}

	

	

}

