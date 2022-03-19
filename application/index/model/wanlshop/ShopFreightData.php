<?php
namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class ShopFreightData extends Model
{

    use SoftDelete;

    // 表名
    protected $name = 'wanlshop_shop_freight_data';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
    
	public function getProvinceAttr($value, $data)

	{

	    return explode(',', $value);

	}

	public function getCityAttr($value, $data)

	{

	    return explode(',', $value);

	}
}
