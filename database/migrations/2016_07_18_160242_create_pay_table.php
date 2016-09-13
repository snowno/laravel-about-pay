<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay',function(Blueprint $table){
//            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('open_id');
            $table->string('pay_type');
            $table->string('out_trade_no');
            $table->string('status');
            $table->string('in_trade_no');
            $table->string('total_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
