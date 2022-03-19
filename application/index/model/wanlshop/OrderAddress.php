<?php
namespace app\index\model\wanlshop;

use think\Model;

class OrderAddress extends Model
{
    // 表名
    protected $name = 'wanlshop_order_address';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

}
