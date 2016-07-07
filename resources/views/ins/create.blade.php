@extends('layouts.app')

@section('content')
    <style>
        .but{
            margin:5px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">create ins</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>新增失败</strong> 输入不符合要求<br><br>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        <form action="{{ url('ins/save') }}" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="file" name="image" required="required" class="but">
                            <input type="text" name="title" class="form-control"  placeholder="说些什么">
                            {{--<textarea name="content" rows="10" class="form-control" required="required" placeholder="请输入内容"></textarea>--}}
                            <br>
                            <button class="btn btn-lg btn-info">save</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
