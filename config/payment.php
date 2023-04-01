<?php
 return [
    'alipay'=>[
        'publicKey' =>env('alipay.public_key',''), //公钥
        'rsaPrivateKey' =>env('alipay.private_key',''), //私钥
        'appid' => env('alipay.appid',''),
        'notify_url' => "https://".env('host')."/notify/alipay",
        'return_url' => "https://".env('host')."/payreturn",
        'charset' => "UTF-8",
        'sign_type'=>"RSA2",
        'gatewayUrl' =>env('alipay.gatewayurl',''),
    ],
    'wechat'=>[
        'mchid'=>env('weixin.merchantid',''),
        'appid'=>env('weixin.appid',''),
        'apiKey'=>env('weixin.key',''),
        'notify_url' => "https://".env('host')."/notify/wechat",
        'return_url' => "https://".env('host')."/payreturn",
    ]
];
