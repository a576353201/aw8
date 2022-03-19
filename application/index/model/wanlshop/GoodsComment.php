<?php
namespace app\index\model\wanlshop;

use think\Model;
use traits\model\SoftDelete;

class GoodsComment extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'wanlshop_goods_comment';
    
    // 自動寫入時間戳字段
    protected $autoWriteTimestamp = 'int';

    // 定義時間戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加屬性
    protected $append = [
        'state_text',
        'status_text'
    ];
    
	// 將圖片數組轉字符串輸入

	public function getImagesAttr($value)

	{

		return $value ? explode(',', $value):[];

	}
    
    public function getStateList()
    {
        return ['0' => __('State 0'), '1' => __('State 1'), '2' => __('State 2')];
    }



    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function user()
    {
        return $this->belongsTo('app\common\model\User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function goods()
    {
        return $this->belongsTo('app\index\model\wanlshop\Goods', 'goods_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
