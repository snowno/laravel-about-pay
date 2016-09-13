<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $fillable = ['open_id', 'user_id', 'out_trade_no', 'pay_type', 'status'];

    
}
