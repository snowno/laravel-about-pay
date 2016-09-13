<?php
/* *
 * 支付宝接口公用函数
 * 详细：该类是请求、通知返回两个文件所调用的公用函数核心处理文件
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

class AlipayCore
{
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
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public static function createLinkstringUrlencode($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".urlencode($val)."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

		return $arg;
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
	 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
	 * 注意：服务器需要开通fopen配置
	 * @param $word 要写入日志里的文本内容 默认值：空值
	 */
	public function logResult($word='') {
		$fp = fopen("log.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	/**
	 * 远程获取数据，POST模式
	 * 注意：
	 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
	 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
	 * @param $url 指定URL完整路径地址
	 * @param $cacert_url 指定当前工作目录绝对路径
	 * @param $para 请求的数据
	 * @param $input_charset 编码格式。默认值：空值
	 * return 远程输出的数据
	 */
	public static function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {

		if (trim($input_charset) != '') {
			$url = $url."_input_charset=".$input_charset;
	//var_dump($url);exit;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl,CURLOPT_POST,true); // post传输数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
		$responseText = curl_exec($curl);
	//	var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
		}

		return $responseText;
	}

	/**
	 * 远程获取数据，GET模式
	 * 注意：
	 * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
	 * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
	 * @param $url 指定URL完整路径地址
	 * @param $cacert_url 指定当前工作目录绝对路径
	 * return 远程输出的数据
	 */
	public static function getHttpResponseGET($url,$cacert_url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
		$responseText = curl_exec($curl);
		//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
		curl_close($curl);
//        file_put_contents("/data/wwwroot/www.5shifu.com/web/app/Http/Controllers/2.txt",$responseText);
		return $responseText;
	}

	/**
	 * 实现多种字符编码方式
	 * @param $input 需要编码的字符串
	 * @param $_output_charset 输出的编码格式
	 * @param $_input_charset 输入的编码格式
	 * return 编码后的字符串
	 */
	public function charsetEncode($input,$_output_charset ,$_input_charset) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $_input_charset;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	/**
	 * 实现多种字符解码方式
	 * @param $input 需要解码的字符串
	 * @param $_output_charset 输出的解码格式
	 * @param $_input_charset 输入的解码格式
	 * return 解码后的字符串
	 */
	public function charsetDecode($input,$_input_charset ,$_output_charset) {
		$output = "";
		if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset changes.");
		return $output;
	}

	public static function getErrMes($err){
		if(!empty($err)){
			switch($err){
				case "ILLEGAL_USER":
					return '用户ID不正确';
				break;
				case "BATCH_NUM_EXCEED_LIMIT":
					return '总比数大于1000';
				break;
				case "REFUND_DATE_ERROR":
					return '错误的退款时间';
					break;
				case "BATCH_NUM_ERROR":
					return '传入的总笔数格式错误';
					break;
				case "BATCH_NUM_NOT_EQUAL_TOTAL":
					return '传入的退款条数不等于数据集解析出的退款条数';
					break;
				case "SINGLE_DETAIL_DATA_EXCEED_LIMIT":
					return '单笔退款明细超出限制';
					break;
				case "NOT_THIS_SELLER_TRADE":
					return '不是当前卖家的交易';
					break;
				case "DUBL_TRADE_NO_IN_SAME_BATCH":
					return '同一批退款中存在两条相同的退款记录';
					break;
				case "DUPLICATE_BATCH_NO":
					return '重复的批次号';
					break;
				case "TRADE_STATUS_ERROR":
					return '交易状态不允许退款';
					break;
				case "BATCH_NO_FORMAT_ERROR":
					return '批次号格式错误';
					break;
				case "SELLER_INFO_NOT_EXIST":
					return '卖家信息不存在';
					break;
				case "PARTNER_NOT_SIGN_PROTOCOL":
					return '平台商未签署协议';
					break;
				case "NOT_THIS_PARTNERS_TRADE":
					return '退款明细非本合作伙伴的交易';
					break;
				case "DETAIL_DATA_FORMAT_ERROR":
					return '数据集参数格式错误';
					break;
				case "PWD_REFUND_NOT_ALLOW_ROYALTY":
					return '有密接口不允许退分润';
					break;
				case "NANHANG_REFUND_CHARGE_AMOUNT_ERROR":
					return '退票面价金额不合法';
					break;
				case "REFUND_AMOUNT_NOT_VALID":
					return '退款金额不合法';
					break;
				case "TRADE_PRODUCT_TYPE_NOT_ALLOW_REFUND":
					return '交易类型不允许退交易';
					break;
				case "RESULT_FACE_AMOUNT_NOT_VALID":
					return '退款票面价不能大于支付票面价';
					break;
				case "REFUND_CHARGE_FEE_ERROR":
					return '退收费金额不合法';
					break;
				case "REASON_REFUND_CHARGE_ERR":
					return '退收费失败';
					break;
				case "RESULT_AMOUNT_NOT_VALID":
					return '退收费金额错误';
					break;
				case "RESULT_ACCOUNT_NO_NOT_VALID":
					return '账号无效';
					break;
				case "REASON_TRADE_REFUND_FEE_ERR":
					return '退款金额错误';
					break;
				case "REASON_HAS_REFUND_FEE_NOT_MATCH":
					return '已退款金额错误';
					break;
				case "TXN_RESULT_ACCOUNT_STATUS_NOT_VALID":
					return '账户状态无效';
					break;
				case "TXN_RESULT_ACCOUNT_BALANCE_NOT_ENOUGH":
					return '账户余额不足';
					break;
				case "REASON_REFUND_AMOUNT_LESS_THAN_COUPON_FEE":
					return '红包无法部分退款';
					break;
				case "BUYER_ERROR":
					return '因买家支付宝账户问题不允许退款';
					break;
				default:
					return $err;
			}
		}
	}

}
?>