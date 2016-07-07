@extends('layouts.app')

@section('content')
    <style>
        .qq-ico{
            display: inline-block;
            width: 64px;
            height: 64px;
            float: left;
            background: url(/app/storage/images/login.png) -64px 0 no-repeat;
        }
        .wx-ico {
            display: inline-block;
            width: 64px;
            height: 64px;
            margin-left: 10px;
            float: left;
            background: url(/app/storage/images/login.png) 0 0 no-repeat;
        }
        .i-ico {
            display: inline-block;
            width: 64px;
            height: 64px;
            float: right;
            background: url(/app/storage/images/login.png) -130px 0 no-repeat;
        }
    </style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="lh-box">

                        </div>
                        <div class="lh-login">
                            <a href="javascript:;" onclick="toQzoneLogin()" class="qq-ico"></a>
                            <a href="javascript:;"  onclick="signLogin()" class="wx-ico"></a>
                            <a href="javascript:;" onclick="wxLogin()" class="i-ico"></a>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
