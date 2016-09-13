<?php

require_once "/vendor/lib/WxPay.Api.php";
require_once '/vendor/lib/WxPay.Notify.php';
require_once '/vendor/lib/log.php';
require_once '/vendor/lib/WxPay.Data.php';

use Lib\Data\WxPayOrderQuery;
use Lib\Wechat\WxPayApi;
use Lib\Logs\Log;
use Lib\Logs\CLogFileHandler;
use App\Pay;


class PayNotifyCallBack extends WxPayNotify
{

    const FILE_PAYED = 'finished';

	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
//		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
//		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
        //修改数据库订单状态
        $file = Pay::where('out_trade_no', $data['out_trade_no'])->first();
        if (!empty($file)) {
            $file->status = self::FILE_PAYED;
//            var_dump($file->status);exit;
            $file->save();
        }
		return true;
	}
	public static function notifyReturn(){
		/*$logHandler= new CLogFileHandler("/storage/logs/wechatpay".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		Log::DEBUG("begin notify");*/
		$notify = new PayNotifyCallBack();
		return $result = $notify->Handle(false);
	}
}
