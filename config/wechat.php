<?php
return [
    'app_id' => env('WECHAT_APP_ID'),
    'secret' => env('WECHAT_APP_SECRET'),
    'log' => [
        'level' => 'debug',
        'file' => storage_path('logs/wechat.log')
    ],
    // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
    'response_type' => 'array',
];
