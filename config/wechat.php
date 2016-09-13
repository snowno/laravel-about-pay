<?php
return [
    'appid'       => 'your appid here', // 必填
    'mchid'       => 'your mchid here', // 必填
    'key'         => 'wechat key here',
    'notifyurl'   => 'notify url here',
    'feetype'     => 'CNY',
    'addr'        => $_SERVER['REMOTE_ADDR'],
    'apiclientcert' => __DIR__.'/../vendor/lib/apiclient_cert.pem',
    'apiclientkey' => __DIR__.'/../vendor/lib/apiclient_key.pem',
    'nonce_str'   => 'test'.rand(100000, 999999),
];