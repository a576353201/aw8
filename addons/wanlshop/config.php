<?php

return [
    [
        'name' => 'ini',
        'title' => '客户端配置11',
        'type' => 'array',
        'value' => [
            'name' => 'hhh',
            'logo' => '/uploads/20210818/03becc284c5e436ea49144f99f2c6277.png',
            'copyright' => 'hhhh',
            'urlschemes' => 'shoppp',
            'package_name' => 'app.shop.pro',
            'cdnurl' => 'https://www.amazon.wealth-mall.com',
            'appurl' => 'https://www.amazon.wealth-mall.com/api',
            'socketurl' => 'ws://127.0.0.1:7272',
            'debug' => 'Y',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '客户端参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'sdk_amap',
        'title' => '高德地图SDK配置',
        'type' => 'array',
        'value' => [
            'amapkey_web' => '1',
            'amapkey_ios' => '1',
            'amapkey_android' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '高德地图SDK参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'sdk_qq',
        'title' => '腾讯开放SDK配置',
        'type' => 'array',
        'value' => [
            'qq_appid' => '1',
            'gz_appid' => '1',
            'wx_appid' => '1',
            'wx_appsecret' => '1',
            'wx_universal_links' => '1',
            'mch_id' => '1',
            'key' => '1',
            'notify_url' => '/wanlshop/callback/notify/type/wechat',
            'pay_cert' => '0',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '腾讯开放SDK参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'sdk_alipay',
        'title' => '支付宝SDK配置',
        'type' => 'array',
        'value' => [
            'app_id' => '1',
            'notify_url' => '/wanlshop/callback/notify/type/alipay',
            'return_url' => '/wanlshop/callback/return/type/alipay',
            'ali_public_key' => '1',
            'private_key' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '支付宝SDK参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'sdk_weibo',
        'title' => '微博开放SDK配置',
        'type' => 'array',
        'value' => [
            'appkey' => '1',
            'appsecret' => '1',
            'redirect_uri' => '/wanlshop/callback/weibo',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '微博开放SDK参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'kuaidi',
        'title' => '快递100 SDK',
        'type' => 'array',
        'value' => [
            'secretKey' => '1',
            'callbackUrl' => '/wanlshop/callback/kuaidi',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '快递100 SDK参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'h5',
        'title' => 'H5客户端',
        'type' => 'array',
        'value' => [
            'domain' => 'https://app.amazon.wealth-mall.com/',
            'title' => 'myweb',
            'router_mode' => 'history',
            'router_base' => './',
            'https' => 'N',
            'qqmap_key' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => 'H5客户端配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mp_weixin',
        'title' => '微信小程序',
        'type' => 'array',
        'value' => [
            'appid' => '1',
            'appsecret' => '1',
            'scope_userLocation' => '演示定位能力',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '微信小程序配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mp_alipay',
        'title' => '支付宝小程序',
        'type' => 'array',
        'value' => [
            'appid' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '支付宝小程序配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mp_baidu',
        'title' => '百度小程序',
        'type' => 'array',
        'value' => [
            'appid' => '',
            'appsecret' => '',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '百度小程序配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mp_toutiao',
        'title' => '头条小程序',
        'type' => 'array',
        'value' => [
            'appid' => '',
            'appsecret' => '',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '头条小程序配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mp_qq',
        'title' => 'QQ小程序',
        'type' => 'array',
        'value' => [
            'appid' => '1',
            'appsecret' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => 'QQ小程序配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'style',
        'title' => '样式配置',
        'type' => 'array',
        'value' => [
            'category_style' => '4',
            'find_bg_color' => '#f7f7f7',
            'find_bg_image' => '/assets/addons/wanlshop/img/find/top_bg.png',
            'find_font_color' => 'light',
            'cart_nav_image' => '',
            'cart_nav_color' => '',
            'cart_font_color' => '',
            'user_nav_color' => '#ffeccc',
            'user_nav_image' => '/uploads/20210816/09e3238e20d260f179490f234e9159cd.png',
            'user_bg_color' => '#ffeccc',
            'user_bg_image' => '/uploads/20210816/6223d58ec0aa8d70bb44d861f2648388.png',
            'user_font_color' => 'dark',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => 'App样式配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'config',
        'title' => '动态客户端配置',
        'type' => 'array',
        'value' => [
            'store_audit' => 'Y',
            'comment_switch' => 'Y',
            'tel_phone' => '0775-12345678',
            'working_hours' => '09:00~22:00',
            'shop_document' => '',
            'shop_qun' => '',
            'user_agreement' => '1',
            'privacy_protection' => '2',
            'help_category' => '263',
            'new_category' => '1',
            'sys_category' => '265',
            'auth_reply' => '你好 很高興为你服务 系統繁忙 请加客服LINE：',
            'not_online' => '正在为您轉接人工客服，请稍等....（如未及時回復，请联絡02号客服LINE ID：）',
            'service_initial' => '正在为您轉接人工客服，请稍等....（如未及時回復，请联絡02号客服LINE ID：）',
            'mp_weixin_id' => '1',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => 'App参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'order',
        'title' => '订单配置',
        'type' => 'array',
        'value' => [
            'cancel' => '2',
            'receiving' => '8',
            'comment' => '2',
            'customer' => '3',
            'autoagree' => '1',
            'returntime' => '1',
            'receivingtime' => '1',
            'wftuitime' => '2',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '订单参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'find',
        'title' => '直播配置',
        'type' => 'array',
        'value' => [
            'app_switch' => [
                'all' => 'all',
                'new' => 'new',
                'live' => 'live',
                'want' => 'want',
                'show' => 'show',
            ],
            'mp_switch' => [
                'all' => 'all',
                'new' => 'new',
                'live' => 'live',
                'want' => 'want',
                'show' => 'show',
            ],
            'h5_switch' => [
                'all' => 'all',
                'new' => 'new',
                'live' => 'live',
                'want' => 'want',
                'show' => 'show',
            ],
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '订单参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'live',
        'title' => '直播配置',
        'type' => 'array',
        'value' => [
            'liveDomain' => '1',
            'pushDomain' => 'rtmp.1.com',
            'builderTime' => '60',
            'pushKey' => '0*****v',
            'liveKey' => 'l*****d',
            'liveCnd' => 'https://play.1.com',
            'appName' => 'shopapp',
            'transTemplate' => 'ld',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '订单参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'withdraw',
        'title' => '提现配置',
        'type' => 'array',
        'value' => [
            'state' => '1',
            'minmoney' => '100',
            'monthlimit' => '6',
            'servicefee' => '2',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '商城提现参数配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'retail',
        'title' => '分销佣金比率',
        'type' => 'array',
        'value' => [
            'child1' => '1',
            'child2' => '2',
            'child3' => '3',
        ],
        'rule' => '',
        'msg' => '',
        'tip' => '商城分销佣金比率配置',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => '__tips__',
        'title' => '温馨提示',
        'type' => 'string',
        'content' => [],
        'value' => '不需要此处配置任何参数，请在 [多用户商城] - [客户端管理]和[系统管理] 中管理配置',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
];
