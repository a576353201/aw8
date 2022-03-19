<?php
namespace app\index\model\wanlshop;

use think\Model;

class KuaidiSub extends Model
{
    // 表名
    protected $name = 'wanlshop_kuaidi_sub';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

}
