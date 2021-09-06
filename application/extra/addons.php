<?php

return [
    'autoload' => false,
    'hooks' => [
        'sms_send' => [
            'smsbao',
        ],
        'sms_notice' => [
            'smsbao',
        ],
        'sms_check' => [
            'smsbao',
        ],
        'upgrade' => [
            'wanlshop',
        ],
        'app_init' => [
            'wanlshop',
        ],
        'user_sidenav_after' => [
            'wanlshop',
        ],
    ],
    'route' => [],
    'priority' => [],
];
