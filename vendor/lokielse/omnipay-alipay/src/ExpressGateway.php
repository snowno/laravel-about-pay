<?php

namespace Omnipay\Alipay;

use AlipayConfig;
/**
 * Class ExpressGateway
 *
 * @package Omnipay\Alipay
 */
class ExpressGateway extends BaseAbstractGateway
{

    protected $service = 'create_direct_pay_by_user';



    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Alipay Express';
    }


    public function purchase(array $parameters = array())
    {
//        var_dump($parameters);exit;
        $this->setService($this->service);

        return $this->createRequest('\Omnipay\Alipay\Message\ExpressPurchaseRequest', $parameters);
    }

    //初始化对象属性 （参数）
    public function parameterInit($obj, $type)
    {

        switch($type){
            //支付
            case 'alipay':

                $obj->setPartner(config('alipay.partner'));
                $obj->setKey(config('alipay.key'));
                $obj->setSellerEmail(config('alipay.selleremail'));
                $obj->setReturnUrl(config('alipay.returnurl'));
                $obj->setNotifyUrl(config('alipay.returnurl'));

                break;

            //支付回调
            case 'alipayReturn':

                $obj->setPartner(config('alipay.partner'));
                $obj->setKey(config('alipay.key'));
                $obj->setSellerEmail(config('alipay.selleremail'));

                break;

            //退款
            case 'alipayRefund':

                $obj->setPartner(config('alipay.partner'));
                $obj->setKey(config('alipay.key'));
                $obj->setSellerEmail(config('alipay.selleremail'));
                $obj->setService(config('alipay.service'));

                break;
            case 'alipayTransfer':
                $obj->setPartner(config('alipay.partner'));
                $obj->setKey(config('alipay.key'));
                $obj->setSellerEmail(config('alipay.selleremail'));
                $obj->setService(config('alipay.transService'));
                break;

        }

        return $obj;
    }

}
