<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pay;

class PayController extends Controller
{
    //未交易完成订单
    public function order()
    {
        $pay = Pay::all()->where('status','prepare');

        return view('admin/pay/order',compact('pay'));
    }
}
