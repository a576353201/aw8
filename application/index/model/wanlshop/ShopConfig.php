<?php
namespace app\index\model\wanlshop;

use think\Model;

/**
 * 配置模型
 */
class ShopConfig extends Model
{

    // 表名,不含前綴
    protected $name = 'wanlshop_shop_config';
    // 自動寫入時間戳字段

    protected $autoWriteTimestamp = 'int';

    

    // 定義時間戳字段名

    protected $createTime = 'createtime';

    protected $updateTime = 'updatetime';

	

	

	public function getTypeList()

	{

	    return [

			'freight' => __('商家店鋪配寘'), 

			//'kuaidi' => __('快遞100雲列印配寘'),

			//'facesheet' => __('面單參數'),

			'mailing' => __('寄件人資訊'),

			'return' => __('退貨資訊')

		];

	}
}
