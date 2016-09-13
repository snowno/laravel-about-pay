<?php
return [
    'appid'       => 'wx618f2ed8a8224b02', // 必填
    'mchid'       => '1305528801', // 必填
    'key'         => '1q0g0p0i2c6atwxPAYyap6C2I0P0G0Q1',
    'notifyurl'   => 'http://test.pay.5shifu.com/wepayReturn/',
    'feetype'     => 'CNY',
    'addr'        => $_SERVER['REMOTE_ADDR'],
    'apiclientcert' => __DIR__.'/../vendor/lib/apiclient_cert.pem',
    'apiclientkey' => __DIR__.'/../vendor/lib/apiclient_key.pem',
    'nonce_str'   => 'qgpic'.rand(100000, 999999),
];