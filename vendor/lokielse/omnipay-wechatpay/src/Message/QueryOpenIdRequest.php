<?php

namespace Omnipay\WechatPay\Message;

use Guzzle\Http\Client;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Common\Helper;
use Omnipay\Common\Message\AbstractRequest;

class QueryOpenIdRequest extends AbstractRequest
{

//    protected $endpoint = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=I0ZkPEYNftwKIyxNuascuUjaMNxgsofoTBCh_ws0mOCIt02GRi_ZP9PNnN45kJ88gihhDJcaNmL_7q9SERpi0kVNYDC1pPaaLeFE-LR7oV1dLGZimXJAc5cBQ-X38VtSFHXdAIAZBR";
    protected $endpoint = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=I0ZkPEYNftwKIyxNuascuUjaMNxgsofoTBCh_ws0mOCIt02GRi_ZP9PNnN45kJ88gihhDJcaNmL_7q9SERpi0kVNYDC1pPaaLeFE-LR7oV1dLGZimXJAc5cBQ-X38VtSFHXdAIAZBR";
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
//            'mch_appid'           => config('wechat.appid'),
            'openid'           => "oFgObwS4X7gFF1HDiBnWYGHENqk0",
        );
        $data = array_filter($data);

//        var_dump($data);exit;
        return $data;
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


        $request      = $this->httpClient->post($this->endpoint)->setBody(json_encode($data));
//        var_dump($request);exit;
        $response     = $request->send()->getBody();
        $responseData = $response;
        var_dump($response);exit;
        return $this->response = new QueryRefundResponse($this, $responseData);

    }
}