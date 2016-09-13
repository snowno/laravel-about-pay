<?php
namespace App\Http\Controllers;
use App\OrderNum;
use App\Test;
use App\Pay;

    class TestController extends Controller{
        public $test;
        public $pay;

        public function __construct(Pay $pay,Test $test){
//            $this->pay = $pay;
            $this->test = $test;
//            var_dump($test);
        }

        public function index(){
            $i = 0;
            $start = microtime(true);
            /*while($i < 1){
                // echo Generate::getId()."\n";
                echo OrderNum::outTradeNo()."\n";
                $i++;
            }*/
            var_dump(OrderNum::outTradeNo());
            $end = microtime(true);

//            echo $end - $start, "\n";
        }

        public function cons(){
            $pay = new Pay();
            $test = new Test($pay);
            $trade = $test->returnCode();
//            var_dump($trade);
        }

        public function test(){
            $arr = [
                'aaa','bbb','ccc','ddd','eee','fff','ggg','hhh','iii','jjj','kkk','lll','yyy','ooo'
            ];
            return view('test.test',compact("arr"));
        }
    }