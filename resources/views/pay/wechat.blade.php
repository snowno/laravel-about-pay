@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div style="text-align:center">
                    <div>
                         <img src="{{$codeUrl}}" width="300" height="300">
                         <div class="scan" style="height:50px;">请使用微信扫一扫以登录</div>
                    </div>
                    <div style="height:500px;text-align:center;display:none;background-color: white" class="mark">
                        <img  src="/assets/images/2.png" alt="">
                    </div>
                    <div id="myDiv">&nbsp; </div>
                    <div  style="margin-bottom:300px" id="timer"></div>
                </div>

            </div>
        </div>
    </div>
    <script>
        //设置每隔1000毫秒执行一次load() 方法
        var myIntval=setInterval(function(){load()},1000);
        function load(){
//                document.getElementById("timer").innerHTML=parseInt(document.getElementById("timer").innerHTML)+1;
            var xmlhttp;
            if (window.XMLHttpRequest){
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }else{
                // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    trade_state=xmlhttp.responseText;
//                    console.log(trade_state);
                    if(trade_state=='SUCCESS'){
                        document.getElementById("myDiv").innerHTML='支付成功';
                        //alert(transaction_id);
                        //延迟3000毫秒执行tz() 方法
                        clearInterval(myIntval);
                        setTimeout("location.href='wepayResult'",3000);

                    }else if(trade_state=='REFUND'){
                        document.getElementById("myDiv").innerHTML='转入退款';
                        clearInterval(myIntval);
                    }else if(trade_state=='NOTPAY'){
                        document.getElementById("myDiv").innerHTML='请扫码支付';

                    }else if(trade_state=='CLOSED'){
                        document.getElementById("myDiv").innerHTML='已关闭';
                        clearInterval(myIntval);
                    }else if(trade_state=='REVOKED'){
                        document.getElementById("myDiv").innerHTML='已撤销';
                        clearInterval(myIntval);
                    }else if(trade_state=='USERPAYING'){
                        document.getElementById("myDiv").innerHTML='用户支付中';
                    }else if(trade_state=='PAYERROR'){
                        document.getElementById("myDiv").innerHTML='支付失败';
                        clearInterval(myIntval);
                    }

                }
            }
            //orderquery 文件返回订单状态，通过订单状态确定支付状态
            xmlhttp.open("POST","orderquery",false);
            //下面这句话必须有
            //把标签/值对添加到要发送的头文件。
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("out_trade_no=<?php echo $out_trade_no;?>");

        }
    </script>
@endsection
