<?php

namespace Omnipay\WechatPay\Message;

use Guzzle\Http\Client;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Common\Helper;


class TransferOrderRequest extends BaseAbstractRequest
{

    protected $endpoint = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate();

        $data = array (
            'mch_appid'           => $this->getAppId(),
            'mchid'          => config('wechat.mchid'),
            'partner_trade_no'     => time().config('wechat.nonce_str'),//<>
            'transaction_id'  => $this->getTransactionId(),
            'openid'    => $this->getOpenId(),
            'check_name'   => $this->getCheckName(),
            're_user_name'       => $this->getReUserName(),
            'amount'      => $this->getAmount(),
            'desc' => $this->getDesc(),
            'spbill_create_ip'      => $this->getSpbillCreateIp(),
            'nonce_str'       => md5(uniqid()),
        );
        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());
        ksort($data);
//        var_dump($data);exit;
        return $data;
    }


    /**
     * @param 设置openid
     * @return openid
     */
    public function setOpenId($openid){

        return$this->setParameter('openid', $openid);
    }

    /**
     * 查询openid的值
     * @return openid值
     */
    public function getOpenId(){

        return $this->getParameter('openid');
    }

    /**
     * 判断openid是否存在
     * @return true or false
     **/
    /*public function openIdIsSet(){

        return array_key_exists('openid',$this->values);
    }*/

    /*
     * 设置价钱
     * @return 价钱
     * */
    public function setAmount($value){
        return $this->setParameter('amount',$value);
    }

    /**
     * 查询amount的值
     * @return amount值
     */
    public function getAmount(){

        return $this->getParameter('amount');
    }

    /**
     * 判断amount是否存在
     * @return true or false
     **/
/*    public function amountIsSet(){

        return array_key_exists('amount',$this->values);
    }*/

    /*
     * 设置校验用户姓名选项
     * NO_CHECK：不校验真实姓名，
     * FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账），
     * OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
     * @return 选项
     * */
    public function setCheckName($value){

        return $this->setParameter('check_name' ,strtoupper($value));
    }

    /**
     * 查询check_name的值
     * @return check_name值
     */
    public function getCheckName(){

        return $this->getParameter('check_name');
    }

    /**
     * 判断check_name是否存在
     * @return true or false
     **/
   /* public function checkNameIsSet(){

        return array_key_exists('check_name',$this->values);
    }*/

    /*
     * 设置描述
     * @return 描述
     * */
    public function setDesc($value){
        return $this->setParameter('desc', $value);
    }

    /**
     * 查询desc的值
     * @return desc值
     */
    public function getDesc(){

        return $this->getParameter('desc');
    }

    /**
     * 判断desc是否存在
     * @return true or false
     **/
   /* public function descIsSet(){

        return array_key_exists('desc',$this->values);
    }*/


    /**
     * 查询mch_appid的值  公众账号appid
     * @return mch_appid值
     */
    public function getMchAppid(){

        return $this->getParameter('mch_appid',config('wechat.appid'));
    }

    /**
     * 判断mch_appid是否存在
     * @return true or false
     **/
    /*public function mchAppidIsSet(){

        return array_key_exists('mch_appid',$this->values);
    }*/

    /**
     * 查询MCHID的值 商户号
     * @return MCHID值
     */
    public function getMCHID(){

        return $this->getParameter('mchid',config('wechat.mchid'));
    }

    /**
     * 判断mchid是否存在
     * @return true or false
     **/
    /*public function mchidIsSet(){

        return array_key_exists('mchid',$this->values);
    }*/

    /**
     * 生成随机数
     * @return 随机数值
     */
    public function getNonceStr(){

        return $this->getParameter('nonce_str','qyzf'.rand(100000, 999999));
    }

    /**
     * 判断随机数是否存在
     * @return true or false
     **/
   /* public function nonceStrIsSet(){

        return array_key_exists('nonce_str',$this->values);
    }*/

    /**
     * 生成用户订单号
     * @return 随机数值
     */
    public function getPartnerTradeNo(){

        return $this->getParameter('partner_trade_no','xx'.time().rand(10000, 99999));
    }

    /**
     * 判断外部订单号是否存在
     * @return true or false
     **/
    /*public function partnerTradeNoIsSet(){

        return array_key_exists('partner_trade_no',$this->values);
    }*/

    /*
     * 设置真实姓名
     * @return name
     * */
    public function setReUserName($value){
        return $this->setParameter('re_user_name',$value);
    }

    /**
     * 查询姓名的值
     * @return 姓名值
     */
    public function getReUserName(){

        return $this->getParameter('re_user_name');
    }

    /**
     * 判断姓名是否存在
     * @return true or false
     **/
 /*   public function reUserNameIsSet(){

        return array_key_exists('re_user_name',$this->values);
    }*/

    /*
     * 设置ip
     * @return ip
     * */
    public function setSpbillCreateIp($value){
        return $this->setParameter('spbill_create_ip', $value);
    }

    /**
     * 查询ip
     * @return ip
     */
    public function getSpbillCreateIp(){

        return $this->getParameter('spbill_create_ip');
    }

    /**
     * 判断ip是否存在
     * @return true or false
     **/
    /*public function spbillCreateIpIsSet(){

        return array_key_exists('spbill_create_ip',$this->values);
    }*/
    /**
     * @return mixed
     */
    public function getCertPath()
    {
        return $this->getParameter('cert_path');
    }


    /**
     * @param mixed $certPath
     */
    public function setCertPath($certPath)
    {
        $this->setParameter('cert_path', $certPath);
    }


    /**
     * @return mixed
     */
    public function getKeyPath()
    {
        return $this->getParameter('key_path');
    }


    /**
     * @param mixed $keyPath
     */
    public function setKeyPath($keyPath)
    {
        $this->setParameter('key_path', $keyPath);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
//        var_dump($data);exit;
        /*$request      = $this->httpClient->post($this->endpoint)->setBody(Helper::array2xml($data));
        $response     = $request->send()->getBody();
        $responseData = Helper::xml2array($response);

        return $this->response = new CloseOrderResponse($this, $responseData);*/


        $options = array (
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSLCERTTYPE    => 'PEM',
            CURLOPT_SSLKEYTYPE     => 'PEM',
            CURLOPT_SSLCERT        => $this->getCertPath(),
            CURLOPT_SSLKEY         => $this->getKeyPath(),
        );

        $body         = Helper::array2xml($data);
        $request      = $this->httpClient->post($this->endpoint, null, $data)->setBody($body);
        $request->getCurlOptions()->merge($options);
        $response     = $request->send()->getBody();
        $responseData = Helper::xml2array($response);

        return $this->response = new CloseOrderResponse($this, $responseData);

    }
}
