<?php namespace App\Http\Controllers;
require_once "/vendor/Lib/WxPay.Api.php";

/*require_once "/vendor/Lib/WxPay.NativePay.php";
require_once "/vendor/Lib/WxPay.Data.php";
require_once "/vendor/Lib/notify.php";*/

require_once "/vendor/alipay/AlipayConfig.php";
//require_once "/vendor/alipay/AlipaySubmit.php";


use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use App\Models\Pay;
//use Lib\Data\WxPayUnifiedOrder;
//use Lib\Data\WxPayDataBase;
//use Lib\Data\WxPaySeller;
//use Lib\Data\WxPayResults;
//use Lib\Wechat\WxPayConfig;
//use Lib\Native\NativePay;
//use Lib\Data\WxPayBizPayUrl;
//use PayNotifyCallBack;
//use Lib\Data\WxPayRefund;
use Lib\Wechat\WxPayApi;
use AlipayConfig;
//use AlipaySubmit;
//use Omnipay;
use Omnipay\Omnipay ;
class PayController extends Controller
{
    public function wechat(Request $request){
        //模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */
        $file_id = $request->input('file_id', '');
        $file_id = mt_rand(1000,9999);
        $out_trade_no = WxPayConfig::MCHID . date("YmdHis") . $file_id;

        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        //订单信息
        $input->SetBody("这是一个花钱的码");                             //扫码支付时最上面的标题
        $input->SetAttach("test");                                       //附加数据 自定义数据
        $input->SetOut_trade_no($out_trade_no);                         //设置商户内部订单号（支付结果会带回来，以便对相应订单状态做更改）
        $input->SetTotal_fee("1");                                      //支付金额，单位是分
        $input->SetTime_start(date("YmdHis"));                          //订单生成时间
        $input->SetTime_expire(date("YmdHis", time() + 600));           //订单失效时间（最短失效时间间隔必须大于5分钟）10
        $input->SetGoods_tag("test");                                   //商品标记
        //这里设置支付成功后的回调接口，不能有参数。还有，这里的127.0.0.1是收不到微信后台发出的回调函数的，只能用服务器来测试了。
        $input->SetNotify_url("http://www.test.com/wxresult");    //接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数（有效url）
        $input->SetTrade_type("NATIVE");        //取值如下：JSAPI，NATIVE，APP  (JSAPI--公众号支付、NATIVE--原生扫码支付、APP--app支付)
        $input->SetProduct_id("123456789");     //二维码中包含的商品id
        $result = $notify->GetPayUrl($input);

        $url = $result["code_url"];

        //生成数据库数据
        $pay = new Pay();
        $pay->out_trade_no = $out_trade_no;
        $pay->status = 'prepare';
        $pay->in_trade_no =  $file_id;
        $pay->pay_type = 'wxpay';
        $pay->total_fee = ($input->GetTotal_fee())/100;
        if(Auth::user()) {
            $pay->user_id = Auth::user()->id;
        }
//        $pay->save();

        $codeUrl = "http://paysdk.weixin.qq.com/example/qrcode.php?data=" . $url;

        return view("pay.wechat",compact("codeUrl"));
    }

    public function wxresult(){
       $return =  PayNotifyCallBack::notifyReturn();
    }

    public function wxrefund(){


        return view('pay.wxrefund');
    }


    public function wxrefunded(Request $request){



        if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != ""){
            $transaction_id = $_REQUEST["transaction_id"];
            $total_fee = $_REQUEST["total_fee"];
            $refund_fee = $_REQUEST["refund_fee"];
            $input = new WxPayRefund();
            $input->SetTransaction_id($transaction_id);
            $input->SetTotal_fee($total_fee);
            $input->SetRefund_fee($refund_fee);
            $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
            $input->SetOp_user_id(WxPayConfig::MCHID);
//            $result = $this->printf_info(WxPayApi::refund($input));
            $result = WxPayApi::refund($input);
        }
        
        //$_REQUEST["out_trade_no"]= "12253127022194108";

        ///$_REQUEST["total_fee"]= "1";
        //$_REQUEST["refund_fee"] = "1";
        if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
            $out_trade_no = $_REQUEST["out_trade_no"];
            $total_fee = $_REQUEST["total_fee"];
            $refund_fee = $_REQUEST["refund_fee"];
            $input = new WxPayRefund();
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee);
            $input->SetRefund_fee($refund_fee);
            $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
            $input->SetOp_user_id(WxPayConfig::MCHID);
//            $result = $this->printf_info(WxPayApi::refund($input));
            $result = WxPayApi::refund($input);
        }
        if(!isset($result['err_code'])){
            if($result['result_code'] == 'SUCCESS'){
                $result = '退款成功，请查看账户。';
            }
        }else{
            $result = '退款失败，'.$result['err_code_des'].'。请重试，或联系管理员。';
        }


        return view('pay.wxrefundreturn',compact("result"));
    }


    /*public function orderstatus(){
        $orderCode = $_POST['orderCode'];
        $order = Pay::where('out_trade_no', $orderCode)->first();
        $data = '';
        $data = (object)$data;
        if (!empty($order)) {
            $order->status = 'finished';
            $order->save();
            $data->data = 'paid';
            $data->state = 'success';
            return $data;
        }

    }*/

    public function alitranspay(){

        return view('pay.alitranspay');
    }

    /* *
    * 功能：批量付款到支付宝账户有密接口接入页
    */
    public function alipayment(){

        $gateway = Omnipay::create('Alipay_Express');

        $gateway = $gateway->parameterInit($gateway,'alipayTransfer');

        //服务器异步通知页面路径

        $notify_url = "http://www.xxx.com/transpayNotify";//需http://格式的完整路径，不允许加?id=123这类自定义参数

        //付款账号
        $email = '123@qq.com';//必填

        //付款账户名
        $account_name = 'xx公司';//必填，个人支付宝账号是真实姓名公司支付宝账号是公司名称

        //付款当天日期
        $pay_date = date("Ymd",time());//必填，格式：年[4位]月[2位]日[2位]，如：20100801

        //批次号
        $batch_no = date("Ymd",time()).sprintf('%u',mt_rand(100,9999999999999999));//必填，格式：当天日期[8位]+序列号[3至16位]，如：201008010000001

        //付款总金额
        $batch_fee = $_POST['WIDbatch_fee'];
        //必填，即参数detail_data的值中所有金额的总和

        //付款笔数
        $batch_num = '1';
        //必填，即参数detail_data的值中，“|”字符出现的数量加1，最大支持1000笔（即“|”字符出现的数量999个）

        //付款详细数据
        $detail_data = $_POST['WIDdetail_data'];
        //必填，格式：流水号1^收款方帐号1^真实姓名^付款金额1^备注说明1|流水号2^收款方帐号2^真实姓名^付款金额2^备注说明2....


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "batch_trans_notify",
            "partner" => config('alipay.partner'),
            "notify_url"  => $notify_url,
            "email"	=> $email,
            "account_name"	=> $account_name,
            "pay_date"	=> $pay_date,
            "batch_no"	=> $batch_no,
            "batch_fee"	=> $batch_fee,
            "batch_num"	=> $batch_num,
            "detail_data"	=> $detail_data,
            "_input_charset"  => 'UTF-8',
        );

        //建立请求
//        $alipaySubmit = new AlipaySubmit(AlipayConfig::getData());
//        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        $response = $gateway->transfer()->buildRequestForm($parameter,'post','');//
        echo $response;
    }


    //根据userid查询用户openid
    public function queryOpenIdByUserId(){//$userId
        $gateway = Omnipay::create('WechatPay_Native');
        $gateway = $gateway->queryOpenId([
            'userid' => "snowno",
        ])->send();
        var_dump($gateway->getData());

        /*$appid = "公众号在微信的appid";
        $secret = "公众号在微信的app secret";
        $code = $_GET["code"];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);*/
//根据openid和access_token查询用户信息
//        $access_token = $json_obj['access_token'];
        /*$access_token = '64gvUtov-TDlMrU3Cv5qRKS6t0BKLyjY3ZbRixzc3dNGvhsthspS_UjbfTBKb1pYpx-rrKORKPD_ZVpxyAA9mTMIbACAHAW';
        $openid = "oFgObwdOb9eIxoJN1lLToPbWuM6Q";
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);

//解析json
        $user_obj = json_decode($res,true);
        $_SESSION['user'] = $user_obj;
        var_dump($user_obj);*/

    }
//    微信提现
    public function wxtranspay(){

        $gateway = Omnipay::create('WechatPay_Native');

        //所需参数
        $openid='oFgObwdOb9eIToPbWuM6Q';//用户唯一标识,上一步授权中获取  //填体现到哪个openid
        $check_name='NO_CHECK';//校验用户姓名选项，NO_CHECK：不校验真实姓名， FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账），OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
        $re_user_name='测试';//用户姓名
        $amount=700;//企业金额，这里是以分为单位（必须大于100分）
        $desc='测试数据';//描述

        $gateway = $gateway->parameterInit($gateway,'wechatpayTransfer');


//       $WxPaySeller=new WxPaySeller();
        $paramter = [
           'amount'  =>  $amount,
           'check_name'  =>  $check_name,
           'desc'  =>  $desc,
           'openid'  =>  $openid,
           'partner_trade_no'  =>  'xxxx'.rand(10000,99999),
           're_user_name'  =>  $re_user_name,
           'spbill_create_ip'  =>  config('wechat.addr'),
       ];
        $response = $gateway->transfer($paramter)->send();//->buildRequestForm($parameter,'post','')

        $data = $response->getData();

        if($data['return_code']=='SUCCESS'){
            if(empty($data['return_msg'])){
                if(isset($data['result_code']) && $data['result_code']=='SUCCESS' ){
                    //数据库操作
                    $payment_no = $data['payment_no'];
                    $partner_trade_no = $data['partner_trade_no'];
                    $payment_time = $data['payment_time'];

                    $result = '提现成功';
                }
            }else{
                $result = '退款失败，'.$data['err_code_des'].'。请重试，或联系管理员。';
            }
        }
       return view('pay.wxtranspay',compact("result"));

    }

    //支付宝扫描支付
    public function alipay(){

//        $gateway = Omnipay::gateway();
        $gateway = Omnipay::create('Alipay_Express');

        $gateway = $gateway->parameterInit($gateway,'alipay');


        $options = [
            'out_trade_no' => date('YmdHis') . mt_rand(1000,9999),
            'subject' => 'Alipay Test',
            'total_fee' => '0.01',
        ];

        $response = $gateway->purchase($options)->send();
        //add 2016/08/02  11：15am
        $response->getRedirectUrl();
        $response->getRedirectData();
        //end add

        //操作数据库
     /*   $pay = new Pay();
        $pay->out_trade_no = $options['out_trade_no'];
        $pay->status = 'NOTPAY';
        $pay->in_trade_no =  mt_rand(1000,9999);
        $pay->pay_type = 'alipay';
        $pay->total_fee = ($options['total_fee']);
        if(Auth::user()) {
            $pay->user_id = Auth::user()->id;
        }*/
//        $pay->save();
        // var_dump($response);exit;
        $response->redirect();
    }

    //支付宝支付回调
    public function alipayReturn(){

        $gateway = Omnipay::create('Alipay_Express');

        $gateway = $gateway->parameterInit($gateway,'alipayReturn');
        
        $options = [
            'request_params'=> $_REQUEST, //Don't use $_REQUEST for may contain $_COOKIE
        ];

        $response = $gateway->completePurchase($options)->send();

        if ($response->isSuccessful()) {

            // Paid success, your statements go here.

            //For notify, response 'success' only please.
            //die('success');
        } else {

            //For notify, response 'fail' only please.
            //die('fail');
        }
    }

    //支付宝退款页面
    public function alipayRefund(){

        return view('pay.alipayRefund');
    }

    //支付宝退款处理
    public function alipayRefunded(){

        $gateway = Omnipay::create('Alipay_Express');

        $gateway = $gateway->parameterInit($gateway,'alipayRefund');


        /*$options =[
            'request_params' => $_POST,
        ];*/
        $parameter = array(
            "service"         => config('alipay.service'),
            "partner"         => config('alipay.seller_user_id'),
            "key"             => config('alipay.key'),
            "notify_url"	  => config('alipay.notify_url'),
            "seller_user_id"  => config('alipay.seller_user_id'),
            "refund_date"	  => trim(date("Y-m-d H:i:s", time())),
            "batch_no"	      => $_POST['WIDbatch_no'],
            "batch_num"       => $_POST['WIDbatch_num'],
            "detail_data"	  => $_POST['WIDdetail_data'],
            "_input_charset"  => trim(strtolower(strtolower('utf-8')))

        );
        $data = AlipayConfig::getData();
        $parameter = array_replace($data,$parameter);
//        var_dump($parameter);exit;
        $response = $gateway->refund()->buildRequestForm($parameter,'post','');//

        echo $response;
//        if ($response->isPaid()) {

            // Paid success, your statements go here.

            //For notify, response 'success' only please.
            //die('success');
//        } else {

            //For notify, response 'fail' only please.
            //die('fail');
//        }
        

    }

    //omnipay wechat
    public function wechatPay(){

        $gateway  = Omnipay::create('WechatPay_Native');

        $gateway = $gateway->parameterInit($gateway,'wechatpay');

        $file_id = mt_rand(1000,9999);
        $out_trade_no = config('wechat.mchid') . date("YmdHis") . $file_id;

        $order = [
            'body'              => 'The test order',
            'out_trade_no'      => $out_trade_no,
            'total_fee'         => 1, //=0.01
            'spbill_create_ip'  => config('wechat.addr'),
            'notify_url'        => config('wechat.notifyurl'),
            'fee_type'          => '',
            'trade_type'=>'NATIVE',

        ];

        $request  = $gateway->purchase($order);
        $response = $request->send();

        //available methods
        $response->isSuccessful();
        $response->getData(); //For debug
        //操作数据库
        $pay = new Pay();
        $pay->out_trade_no = $out_trade_no;
        $pay->status = 'NOTPAY';
        $pay->in_trade_no =  $file_id;
        $pay->pay_type = 'wechat';
        $pay->total_fee = ($order['total_fee'])/100;
        if(Auth::user()) {
            $pay->user_id = Auth::user()->id;
        }
        $pay->save();

        $codeUrl = "http://paysdk.weixin.qq.com/example/qrcode.php?data=" .$response->getCodeUrl(); //For Native Trade Type

        return view('pay.wechat',compact("codeUrl","out_trade_no"));
    }

    //微信支付回调
    public function wechatReturn(){
        $gateway  = Omnipay::create('WechatPay_Native');

        $gateway = $gateway->parameterInit($gateway,'wechatpayReturn');

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

    }

    //omnipay 微信退款
    public function wechatRefund(){
        $gateway  = Omnipay::create('WechatPay_Native');

        $gateway = $gateway->parameterInit($gateway,'wechatpayRefund');

        $response = $gateway->refund([
           'transaction_id' => '400072600026727128', //The wechat trade no
            'out_refund_no' => date('YmdHis').mt_rand(1000, 9999),
            'out_trade_no' => '1305528291044197165',
            'total_fee' => 1, //=0.01
            'refund_fee' => 1, //=0.01
        ])->send();

        if($response->isSuccessful() && $response->getData()['result_code'] == 'SUCCESS'){
            $result = '退款成功，请查看账户。';
        }else{
            $result = '退款失败，'.$response->getData()['err_code_des'].'。请重试，或联系管理员。';
        }

        return view('pay.wxrefundreturn',compact("result"));
    }

    //查询订单状态
    public  function orderquery(){
        $gateway  = Omnipay::create('WechatPay_Native');

        $gateway = $gateway->parameterInit($gateway,'wechatpayQuery');

        $response = $gateway->query([
            'out_trade_no' => $_REQUEST["out_trade_no"],
        ])->send();
        echo $response->getData()['trade_state'];

    }

    //支付结果页面
    public function wepayResult(){

        return view("pay.wepayResult");
    }

    //关闭订单
    public function wechatCloseOrder($order){
        if(!isset($order)){
            return;
        }
        $gateway = Omnipay::create('WechatPay_Native');
        $gateway = $gateway->parameterInit($gateway,'wechatCloseOrder');

        $response = $gateway->close([

            'out_trade_no' =>  '130520111709509134',

            'nonce_str'  => config('wechat.nonce_str'),
        ])->send();
        $data = $response->getData();
        if($response->isSuccessful() && $data['return_code'] == 'SUCCESS'){
            if($data['result_code'] == 'SUCCESS'){
                $result = '订单成功关闭。';
                //更新数据库订单状态
                /*DB::table('pays')

                    ->where('out_trade_no', '130552880120109134')

                    ->update(array('status' => 'CLOSE'));*/
            }else{
                $err_mes = $gateway->orderStatus($data['err_code']);
                $result = '订单关闭失败，失败代码是'.$err_mes.'。';
            }
        }

        return view('pay.wechatCloseOrder',compact("result"));
    }

}
