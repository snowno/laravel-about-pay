@extends('layouts.app')
@section('title')
    首页_5师傅
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div style="text-align:center">
                    <div style="height:700px;line-height: 500px">
                        <span style="font-size:20px">{{$result}}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection