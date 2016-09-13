@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div style="text-align:center">
                    <div>
                        <form action="/wxrefunded" method="post">
                            <div style="margin-left:2%;color:#f00">微信订单号和商户订单号选少填一个，微信订单号优先：</div><br/>
                            <div style="margin-left:2%;">微信订单号：</div><br/>
                            <input type="text" style="width:96%;height:35px;margin-left:2%;" name="transaction_id" /><br /><br />
                            <div style="margin-left:2%;">商户订单号：</div><br/>
                            <input type="text" style="width:96%;height:35px;margin-left:2%;" name="out_trade_no" /><br /><br />
                            <div style="margin-left:2%;">订单总金额(分)：</div><br/>
                            <input type="text" style="width:96%;height:35px;margin-left:2%;" name="total_fee" /><br /><br />
                            <div style="margin-left:2%;">退款金额(分)：</div><br/>
                            <input type="text" style="width:96%;height:35px;margin-left:2%;" name="refund_fee" /><br /><br />
                            <div align="center">
                                <input type="submit" value="提交退款" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"   />
                            </div>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
