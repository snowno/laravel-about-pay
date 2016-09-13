<?php

return [

	// The default gateway to use
	'default' => '',

	// Add in each gateway here
	'gateways' => [
		'alipay' => [
			'driver' => 'Alipay_Express',
			'options' => [
				'partner' => 'partner here',
				'key' => 'key here',
				'sellerEmail' =>'email here',
				'returnUrl' => 'alipayPayReturn url here',
				'notifyUrl' => 'alipayRefundNotify url here',
				'notify_url'  => "alipayPayNotify url here",
				'service'    => 'refund_fastpay_by_platform_pwd',
				'company'    => 'xxx company',

			]
		],
		'wechat' => [
			'driver' => 'WechatPay_Native',
			'options' => [
				'appid'       => 'appid here', // 必填
				'mchid'       => 'mchid here', // 必填
				'apiKey'         => 'apikey here',
				'notify_url'   => 'wechatPayReturn url here',
				'feetype'     => 'CNY',
				'certPath' => __DIR__.'/apiclient_cert.pem',
				'keyPath' => __DIR__.'/apiclient_key.pem',
				'nonce_str'   => 'xxx'.rand(100000, 999999),
				'spbill_create_ip' => 'your ip here',
			]
		]
	]

];
