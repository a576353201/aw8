<?php

namespace app\admin\model\wanlshop;

use think\Model;

class Config extends Model
{
    // 表名
    protected $name = 'wanlshop_commission_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 追加属性
    protected $append = [
    ];

}
