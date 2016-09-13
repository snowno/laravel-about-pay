@extends('frontend.bas')
@section('title')
    首页_5师傅
@stop

@section('main')
    <button type="button" onclick="WXPayment()">
        支付 ￥<?php echo ($order->total_fee / 100); ?> 元
    </button>

@stop
@section('footer_js')
    <script type="text/javascript">
        var WXPayment = function() {
            if( typeof WeixinJSBridge === 'undefined' ) {
                alert('请在微信在打开页面！');
                return true;
            }
            WeixinJSBridge.invoke(
                    'getBrandWCPayRequest', <?php echo $payment->getConfig(); ?>, function(res) {
                        switch(res.err_msg) {
                            case 'get_brand_wcpay_request:cancel':
                                alert('用户取消支付！');
                                break;
                            case 'get_brand_wcpay_request:fail':
                                alert('支付失败！（'+res.err_desc+'）');
                                break;
                            case 'get_brand_wcpay_request:ok':
                                alert('支付成功！');
                                break;
                            default:
                                alert(JSON.stringify(res));
                                break;
                        }
                    }
            );
        }
    </script>
@stop
