<?php
return [
    'Id' => 'Id',
    'Shop_category_id' => 'Shop_category_id',
    'Shopsort.name' => 'Shopsort.name',
    'Category_id' => 'Category_id',
    'Category.name' => 'Category.name',
    'Title' => 'Title',
    'Image' => 'Image',
    'Images' => 'Images',
    'Description' => 'Description',
    'Flag' => 'Flag',
    'Flag hot' => 'Flag hot',
    'Flag index' => 'Flag index',
    'Flag recommend' => 'Flag recommend',
    'Stock' => 'Stock',
    'Stock porder' => 'Stock porder',
    'Stock payment' => 'Stock payment',
    'Content' => 'Content',
    'Price' => 'Price',
    'Freight_id' => 'Freight_id',
    'Grounding' => 'Grounding',
    'Specs' => 'Specs',
    'Specs single' => 'Specs single',
    'Specs multi' => 'Specs multi',
    'Distribution' => 'Distribution',
    'Distribution true' => 'Distribution true',
    'Distribution false' => 'Distribution false',
    'Activity' => 'Activity',
    'Activity true' => 'Activity true',
    'Activity false' => 'Activity false',
    'Views' => 'Views',
    'Sales' => 'Sales',
    'Comment' => 'Comment',
    'Praise' => 'Praise',
    'Like' => 'Like',
    'Weigh' => 'Weigh',
    'Createtime' => 'Createtime',
    'Updatetime' => 'Updatetime',
    'Deletetime' => 'Deletetime',
    'Status' => 'Status',
    'All' => 'All',
    'Del' => 'Del',
    'Normal' => 'Normal',
    'Hidden' => 'Hidden',
    'Set to normal' => 'Set to normal',
    'Set to hidden' => 'Set to hidden',
    'Import' => 'Import',
    'Export' => 'Export',
    'Recycle bin' => 'Recycle bin',
    'Restore' => 'Restore',
    'Restore all' => 'Restore all',
    'Destroy' => 'Destroy',
    'Destroy all' => 'Destroy all',
    'Nothing need restore' => 'Nothing need restore',
    'Drag to sort' => 'Drag to sort',
    'Redirect now' => 'Redirect now',
    'Key' => 'Key',
    'Value' => 'Value',
    'Common search' => 'Common search',
    'Search %s' => 'Search %s',
    'View %s' => 'View %s',
    'Click to search %s' => 'Click to search %s',
    'Operation completed' => 'Operation completed',
    'Operation failed' => 'Operation failed',
    'Unknown data format' => 'Unknown data format',
    'Network error' => 'Network error',
    'Invalid parameters' => 'Invalid parameters',
    'No results were found' => 'No results were found',
    'No rows were inserted' => 'No rows were inserted',
    'No rows were deleted' => 'No rows were deleted',
    'No rows were updated' => 'No rows were updated',
    'Parameter %s can not be empty' => 'Parameter %s can not be empty',
    'Are you sure you want to delete the %s selected item?' => 'Are you sure you want to delete the %s selected item?',
    'Are you sure you want to delete this item?' => 'Are you sure you want to delete this item?',
    'Are you sure you want to delete or turncate?' => 'Are you sure you want to delete or turncate?',
    'Are you sure you want to truncate?' => 'Are you sure you want to truncate?'
];



/*return [
    'Id'                 => 'ID',
    'Shop_category_id'   => '店鋪內類目',

	'Shopsort.name'      => '店鋪內類目',
    'Category_id'        => '商品類目',

	'Category.name'      => '商品類目',

    'Title'              => '商品標題',
    'Image'              => '商品主圖',
    'Images'             => '商品相冊',
    'Description'        => '商品描述',
    'Flag'               => '標誌(多選)',
    'Flag hot'           => '熱門',
    'Flag index'         => '首頁',
    'Flag recommend'     => '推薦',
    'Stock'              => '庫存計算方式',
    'Stock porder'       => '下單減庫存',
    'Stock payment'      => '付款減庫存',
    'Content'            => '商品詳情',
    'Price'              => '產品價格',
    'Freight_id'         => '運費模板',
    'Grounding'          => '上架狀態',
    'Specs'              => '商品規格',
    'Specs single'       => '單規格',
    'Specs multi'        => '多規格',
    'Distribution'       => '是否獨立分銷',
    'Distribution true'  => '開啓',
    'Distribution false' => 'Distribution false',
    'Activity'           => '是否活動中',
    'Activity true'      => '是',
    'Activity false'     => '否',
    'Views'              => '點擊',
    'Sales'              => '銷量',
    'Comment'            => '評論',
    'Praise'             => '好評',
    'Like'               => '收藏',
    'Weigh'              => '權重',
    'Createtime'         => '創建時間',
    'Updatetime'         => '更新時間',
    'Deletetime'         => '刪除時間',
    'Status'             => '上架狀態',

	// 追加數據

	'All'                                                   => '全部商品',

	'Del'													=> '刪除',

	'Normal'                                                => '正常',

	'Hidden'                                                => '下架',

	'Set to normal'      => '上架商品',

	'Set to hidden'      => '下架商品',

	'Import'                                                => '導入',

	'Export'                                                => '導出',

	'Recycle bin'                                           => '商品回收站',

	'Restore'                                               => '還原',

	'Restore all'                                           => '還原全部',

	'Destroy'                                               => '銷毀',

	'Destroy all'                                           => '清空回收站',

	'Nothing need restore'                                  => '沒有需要還原的數據',

	'Drag to sort'                                          => '拖動進行排序',

	'Redirect now'                                          => '立即跳轉',

	'Key'                                                   => '鍵',

	'Value'                                                 => '值',

	'Common search'                                         => '普通搜索',

	'Search %s'                                             => '搜索 %s',

	'View %s'                                               => '查看 %s',

	'Click to search %s'                                    => '點擊搜索 %s',

	'Operation completed'                                   => '操作成功!',

	'Operation failed'                                      => '操作失敗!',

	'Unknown data format'                                   => '未知的數據格式!',

	'Network error'                                         => '網絡錯誤!',

	'Invalid parameters'                                    => '未知參數',

	'No results were found'                                 => '記錄未找到',

	'No rows were inserted'                                 => '未插入任何行',

	'No rows were deleted'                                  => '未刪除任何行',

	'No rows were updated'                                  => '未更新任何行',

	'Parameter %s can not be empty'                         => '參數%s不能爲空',

	'Are you sure you want to delete the %s selected item?' => 'Are you sure you want to delete the %s selected item?',

	'Are you sure you want to delete this item?'            => '確定刪除此項?',

	'Are you sure you want to delete or turncate?'          => '確定刪除或清空?',

	'Are you sure you want to truncate?'                    => '確定清空?'

];*/
