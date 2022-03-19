<?php

namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class Find extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_find';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加屬性
    protected $append = [
        'type_text'
    ];
    

    
    public function getTypeList()
    {
        return ['new' => __('Type new'), 'live' => __('Type live'), 'want' => __('Type want'), 'activity' => __('Type activity'), 'show' => __('Type show')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

	public function setImagesAttr($value)

	{

	    return is_array($value) ? implode(',', $value) : $value;

	}
		
	public function setGoodsIdsAttr($value)

	{

	    return is_array($value) ? implode(',', $value) : $value;

	}
    
}
