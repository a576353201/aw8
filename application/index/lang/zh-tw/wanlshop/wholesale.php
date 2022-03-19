<?php


return [
    'Id' => 'ID',
    'Shop_category_id' => '店鋪內類目',
    'Shopsort.name' => '店鋪內類目',
    'Category_id' => '商品類目',
    'Category.name' => '商品類目',
    'Title' => '商品標題',
    'Image' => '商品主圖',
    'Images' => '商品相冊',
    'Description' => '商品描述',
    'Flag' => '標誌（多選）',
    'Flag hot' => '熱門',
    'Flag index' => '首頁',
    'Flag recommend' => '推薦',
    'Stock' => '庫存計算管道',
    'Stock porder' => '下單減庫存',
    'Stock payment' => '付款減庫存',
    'Content' => '商品詳情',
    'Price' => '產品價格',
    'Freight_id' => '運費範本',
    'Grounding' => '上架狀態',
    'Specs' => '商品規格',
    'Specs single' => '單規格',
    'Specs multi' => '多規格',
    'Distribution' => '是否獨立分銷',
    'Distribution true' => '開啟',
    'Distribution false' => '關閉',
    'Activity' => '是否活動中',
    'Activity true' => '是',
    'Activity false' => '否',
    'Views' => '點擊',
    'Sales' => '銷量',
    'Comment' => '評論',
    'Praise' => '好評',
    'Like' => '收藏',
    'Weigh' => '權重',
    'Createtime' => '創建時間',
    'Updatetime' => '更新時間',
    'Deletetime' => '刪除時間',
    'Status' => '上架狀態',
    //追加數據
    'All' => '全部商品',
    'On the shelf' => '已上架',
    'Not on sale' => '未上架',
    'Del' => '刪除',
    'Normal' => '正常',
    'Hidden' => '下架',
    'Set to normal' => '上架商品',
    'Set to hidden' => '下架商品',
    'Import' => '導入',
    'Export' => '匯出',
    'Recycle bin' => '商品回收站',
    'Restore' => '還原',
    'Restore all' => '還原全部',
    'Destroy' => '銷毀',
    'Destroy all' => '清空回收站',
    'Nothing need restore' => '沒有需要還原的數據',
    'Drag to sort' => '拖動進行排序',
    'Redirect now' => '立即跳轉',
    'Key' => '鍵',
    'Value' => '值',
    'Common search' => '普通搜索',
    'Search %s' => '搜索%s',
    'View %s' => '查看%s',
    'Click to search %s' => '點擊搜索%s',
    'Operation completed' => '操作成功！',
    'Operation failed' => '操作失敗！',
    'Unknown data format' => '未知的數據格式！',
    'Network error' => '網絡錯誤！',
    'Invalid parameters' => '未知參數',
    'No results were found' => '條未找到',
    'No rows were inserted' => '未插入任何行',
    'No rows were deleted' => '未刪除任何行',
    'No rows were updated' => '未更新任何行',
    'Parameter %s can not be empty' => '參數%s不能爲空',
    'Are you sure you want to delete the %s selected item?' => '確定刪除選中的%s項?',
    'Are you sure you want to delete this item?' => '確定刪除此項?',
    'Are you sure you want to delete or turncate?' => '確定刪除或清空?',
    'Are you sure you want to truncate?' => '確定清空?'
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
    'Distribution false' => '關閉',
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

	'Are you sure you want to delete the %s selected item?' => '確定刪除選中的 %s 項?',

	'Are you sure you want to delete this item?'            => '確定刪除此項?',

	'Are you sure you want to delete or turncate?'          => '確定刪除或清空?',

	'Are you sure you want to truncate?'                    => '確定清空?'

];*/
