<?php

namespace Omnipay\Alipay\Message;

use Guzzle\Http\Client;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Common\Helper;

/**
 * Class RefundOrderRequest
 * @package Omnipay\Alipay\Message
 * @method RefundOrderResponse send()
 */
class RefundOrderRequest extends BaseRefundRequest
{

    protected $endpoint = 'https://mapi.alipay.com/gateway.do?';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate();//'batch_no', 'batch_num', 'detail_data'
//        $this->validateData();

        $data              = array(
            "service"            => $this->getService(),
            "partner"            => $this->getPartner(),
            "payment_type"       => $this->getPaymentType(),
            "seller_email"       => $this->getSellerEmail(),
            "out_trade_no"       => $this->getOutTradeNo(),
            "subject"            => $this->getSubject(),
            "total_fee"          => $this->getTotalFee(),
            "currency"           => $this->getCurrency(),
            "body"               => $this->getBody(),
            "show_url"           => $this->getShowUrl(),
           /* "anti_phishing_key"  => $this->getAntiPhishingKey(),
            "exter_invoke_ip"    => $this->getExterInvokeIp(),
            "paymethod"          => $this->getPayMethod(),
            "defaultbank"        => $this->getDefaultBank(),
            "_input_charset"     => $this->getInputCharset(),
            "extra_common_param" => $this->getExtraCommonParam(),
            "extend_param"       => $this->getExtendParam(),*/
        );
        $data              = array_filter($data);
        $data['sign']      = $this->getParamsSignature($data);
        $data['sign_type'] = $this->getSignType();

        return $data;
    }


    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @param mixed $outTradeNo
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * @return mixed
     */
    public function getOpUserId()
    {
        return $this->getParameter('op_user_id');
    }


    /**
     * @param mixed $opUserId
     */
    public function setOpUserId($opUserId)
    {
        $this->setParameter('op_user_id', $opUserId);
    }


    /**
     * @return mixed
     */
    public function getOutRefundNo()
    {
        return $this->getParameter('out_refund_no');
    }


    /**
     * @param mixed $outRefundNo
     */
    public function setOutRefundNo($outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }


    /**
     * @return mixed
     */
    public function getDeviceInfo()
    {
        return $this->getParameter('device_Info');
    }


    /**
     * @param mixed $deviceInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }


    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }


    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }


    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->getParameter('total_fee');
    }


    /**
     * @param mixed $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->setParameter('total_fee', $totalFee);
    }


    /**
     * @return mixed
     */
    public function getRefundFee()
    {
        return $this->getParameter('refund_fee');
    }


    /**
     * @param mixed $refundFee
     */
    public function setRefundFee($refundFee)
    {
        $this->setParameter('refund_fee', $refundFee);
    }


    /**
     * @return mixed
     */
    public function getRefundType()
    {
        return $this->getParameter('refund_fee_type');
    }


    /**
     * @param mixed $refundFeeType
     */
    public function setRefundType($refundFeeType)
    {
        $this->setParameter('refund_fee_type', $refundFeeType);
    }


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

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
    public function buildRequestForm($para_temp, $method, $button_name) {

        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
//        var_dump($para);exit;
        $sHtml = '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
        $sHtml = $sHtml."<form id='alipaysubmit' name='alipaysubmit' action='".$this->endpoint."_input_charset=".trim(strtolower($para_temp['input_charset']))."' method='".$method."'>";
        while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."</form>";

        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    public function buildRequestPara($para_temp) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = self::paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = self::argSort($para_filter);

        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort,$para_temp);

        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = strtoupper(trim(strtoupper('MD5')));
//        var_dump($para_sort);exit;
        return $para_sort;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public static function paraFilter($para) {
        $para_filter = array();
        while (list ($key, $val) = each ($para)) {
            if($key == "sign" || $key == "sign_type" || $val == "")continue;
            else	$para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }
    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    public static function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function buildRequestMysign($para_sort,$para_temp) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = self::createLinkstring($para_sort);

        $mysign = "";
        switch (strtoupper(trim(strtoupper('MD5')))) {
            case "MD5" :
                $mysign = self::md5Sign($prestr, $para_temp['key']);
                break;
            default :
                $mysign = "";
        }

        return $mysign;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public static  function createLinkstring($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * return 签名结果
     */
    public static function md5Sign($prestr, $key) {
        $prestr = $prestr . $key;
        return md5($prestr);
    }
}
