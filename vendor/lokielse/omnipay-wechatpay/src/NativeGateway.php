<?php

namespace Omnipay\WechatPay;

/**
 * Class NativeGateway
 * @package Omnipay\WechatPay
 */
class NativeGateway extends BaseAbstractGateway
{

    public function getName()
    {
        return 'WechatPay Native';
    }


    public function getTradeType()
    {
        return 'NATIVE';
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\WechatPay\Message\ShortenUrlRequest
     */
    public function shortenUrl($parameters = array ())
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\ShortenUrlRequest', $parameters);
    }

    /*
     * param init
     * */
    public function parameterInit($obj, $type){
        switch($type){
            case 'wechatpay':
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                $obj->setApiKey(config('wechat.key'));
                break;
            case 'wechatpayReturn':
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                $obj->setApiKey(config('wechat.key'));
                break;
            case 'wechatpayRefund':
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                $obj->setApiKey(config('wechat.key'));
                $obj->setCertPath(config('wechat.apiclientcert'));//__DIR__.\"/../../../vendor/lib/apiclient_cert.pem
                $obj->setKeyPath(config('wechat.apiclientkey'));
                break;
            case 'wechatpayQuery':
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                $obj->setApiKey(config('wechat.key'));
                break;
            case 'wechatpayTransfer':
                $obj->setCertPath(config('wechat.apiclientcert'));//__DIR__.\"/../../../vendor/lib/apiclient_cert.pem
                $obj->setKeyPath(config('wechat.apiclientkey'));
                $obj->setApiKey(config('wechat.key'));
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                break;
            case 'wechatCloseOrder':
                $obj->setAppId(config('wechat.appid'));
                $obj->setMchId(config('wechat.mchid'));
                $obj->setApiKey(config('wechat.key'));
                break;

        }

        return $obj;
    }

    //关闭订单错误状态接续
    public function orderStatus($parameter){
        switch($parameter){
            case 'ORDERPAID':
                return '订单已支付，不能发起关单';
                break;
            case 'SYSTEMERROR':
                return '系统错误';
                break;

            case 'ORDERNOTEXIST':
                return '订单系统不存在此订单';
                break;
            case 'ORDERCLOSED':
                return '订单已关闭，无法重复关闭';
                break;
            case 'SIGNERROR':
                return '签名错误';
                break;
            case 'REQUIRE_POST_METHOD':
                return '请使用post方法';
                break;
            case 'XML_FORMAT_ERROR':
                return 'XML格式错误';
                break;


        }
    }
}
