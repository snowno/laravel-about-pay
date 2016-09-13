<?php

return [

	// The default gateway to use
	'default' => '',

	// Add in each gateway here
	'gateways' => [
		'alipay' => [
			'driver' => 'Alipay_Express',
			'options' => [
				'partner' => '2088121545620653',
				'key' => 'cmjw4atggmx1p9zhxlbn3ke9cn9gfg8i',
				'sellerEmail' =>'myaccount@qgpic.com',
				'returnUrl' => 'http://www.5shifu.com/dashboard/pay/alipayReturn',
				'notifyUrl' => 'http://www.5shifu.com/dashboard/pay/alipayReturn',
				'notify_url'  => "http://www.5shifu.com/dashboard/pay/alipayNotify",
				'service'    => 'refund_fastpay_by_platform_pwd',
				'company'    => '北京奇光影业有限公司',

			]
		],
		'wechat' => [
			'driver' => 'WechatPay_Native',
			'options' => [
				'appid'       => 'wx618f2ed8a8224b02', // 必填
				'mchid'       => '1305528801', // 必填
				'apiKey'         => '1q0g0p0i2c6atwxPAYyap6C2I0P0G0Q1',
				'notify_url'   => 'http://www.5shifu.com/dashboard/pay/wechatReturn',
				'feetype'     => 'CNY',
				'certPath' => __DIR__.'/apiclient_cert.pem',
				'keyPath' => __DIR__.'/apiclient_key.pem',
				'nonce_str'   => 'qgpic'.rand(100000, 999999),
				'spbill_create_ip' => '101.201.53.144',
			]
		]
	]

];
