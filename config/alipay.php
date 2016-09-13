<?php
return [
    
    // 合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
    'partner' => 'your ID',

    // 卖家支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
    'seller_user_id' => 'your alipay id',

    // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
    'key'    => 'your KEY',

    // 服务器异步通知页面路径，需http://格式的完整路径，不能加?id=123这类自定义参数,必须外网可以正常访问
    'notify_url'  => "your url here",

    // 签名方式
    'sign_type'  => strtoupper('MD5'),

    // 退款日期 时间格式 yyyy-MM-dd HH:mm:ss
    'refund_date' => date("Y-m-d H:i:s", time()),

    // 退款调用的接口名，无需修改
    'service'  => 'refund_fastpay_by_platform_pwd',

    //字符编码格式 目前支持 gbk 或 utf-8
    'input_charset' => strtolower('utf-8'),

    //ca证书路径地址，用于curl中ssl校验
    'cacert'  =>  __DIR__.'/../vendor/lokielse/omnipay-alipay/cacert.pem',

    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'transport' => 'http',

    //支付return_url
    'returnurl' => 'your reurn url',

    //商家邮箱
    'selleremail' => 'your email',

    'addr'        => $_SERVER['REMOTE_ADDR'],

    'transService'    => 'batch_trans_notify',

];