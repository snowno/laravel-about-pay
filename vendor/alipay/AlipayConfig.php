<?php

class AlipayConfig
{
    /**
     * 获取配置信息的数组
     * */
    public static function getData(){
        $return = array(
             "seller_user_id"=>config('alipay.seller_user_id'),
             "partner"=>config('alipay.seller_user_id'),
             "key"=>config('alipay.key'),
             "notify_url"=>config('alipay.notify_url'),
             "service"=>config('alipay.service'),
             "cacert"=>config('alipay.cacert'),
             "transport"=>config('alipay.transport'),
             "sign_type" =>config('alipay.sign_type'),
             "input_charset"=> config('alipay.input_charset'),
             "refund_date"=>config('alipay.refund_date'),
            );
        return $return;
    }
}
?>