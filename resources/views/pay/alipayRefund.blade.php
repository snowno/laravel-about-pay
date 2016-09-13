@extends('layouts.app')
@section('title')
    首页_5师傅
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div style="text-align:center">
                    <div style="height:600px">
                        <form action="alipayRefunded" class="alipayform" method="post" target="_blank">
                            <div class="element" style="margin-top:60px;">
                                <div class="legend">支付宝即时到账批量退款有密接口快速通道 </div>
                            </div>
                            <div class="element">
                                <div class="etitle">退款批次号:</div>
                                <div class="einput"><input type="text" name="WIDbatch_no" id="WIDbatch_no"></div>
                                <br>
                                <div class="mark">注意：退款批次号(batch_no)，必填(时间格式是yyyyMMddHHmmss+数字或者字母)</div>
                            </div>

                            <div class="element">
                                <div class="etitle">退款笔数:</div>
                                <div class="einput"><input type="text" name="WIDbatch_num" ></div>
                                <br>
                                <div class="mark">注意：退款笔数(batch_num)，必填(值为您退款的笔数,取值1~1000间的整数)</div>
                            </div>
                            <div class="element">
                                <div class="etitle">退款详细数据:</div>
                                <div class="einput"><input type="text" name="WIDdetail_data"></div>
                                <br>
                                <div class="mark">注意：退款详细数据(WIDdetail_data)，必填(支付宝交易号^退款金额^备注)多笔请用#隔开</div>
                            </div>
                            <div class="element">
                                <input type="submit" class="alisubmit" value ="确认支付">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection