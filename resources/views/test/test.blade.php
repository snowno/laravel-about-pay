@extends('layouts.app')

@section('content')
    <style>
        .text-center {
            text-align:center;
            width:50%;
            margin:0 auto;
        }
        .item{
            display:table-inline;
            width:20px;
            height:20px;
            border-radius:10px;
            background:red;
            content:" ";
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div style="text-align:center">

                    <?php
                    $total = 24 ; //数据条数

                    $j = 0; //其实数据编号
                    $m = 2;	//起始偏移量
                    $p = 1; //指针控制，起始＋，后来变为－
                    $t = 5; //最大行数据个数
                        ?>
                    <div class="text-center">
                        <?php for($i = 1 ; $i < $total ; $i++){ ?>
                        <span class="item">----</span>
                        <?php
                        if($i >= $j + $m){
                            $j = $j + $m;$m = $m + $p;
                            echo "<br />";
                            if($m >= $t){
                                $p = -1;
                            }
                        }
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
