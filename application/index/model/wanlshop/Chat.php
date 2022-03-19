<?php

namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Chat extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_chat';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

	

	public function getMessageAttr($value)

	{

		$status = json_decode($value, true);

	    return $status;

	}

	

	public function getFormAttr($value)

	{

		$status = json_decode($value, true);

	    return $status;

	}
}
