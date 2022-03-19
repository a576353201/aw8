<?php

namespace app\index\model\wanlshop;

use think\Model;

class Attribute extends Model
{
    // 表名
    protected $name = 'wanlshop_category_attribute';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
	
	/**
	 * 將value字段轉換數組
	 */
	public function getValueAttr($value)
	{
		$status = json_decode($value, true);
	    return $status;
	}
}
