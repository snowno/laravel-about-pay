@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">  <button><a href="{{url('ins/create')}}">update</a></button></div>

                    <div class="panel-body">
                        <div>
                            {{--<div> <a href="{{ url('ins/detail/'.$user->id) }}" ><img src="{{'/app/storage/uploads/'.$user->image}}" width="50" height="50"></a></div>--}}
                           {{-- <table style="border:1px solid #ccc;width:400px">
                                <tr style="border:1px solid #ccc;width:400px">
                                    <td style="border:1px solid #ccc">id</td>
                                    <td style="border:1px solid #ccc">name</td>
                                    <td style="border:1px solid #ccc">email</td>
                                    <td style="border:1px solid #ccc">created_at</td>
                                </tr>
                                <tr style="border:1px solid #ccc;width:400px">
                                    <td style="border:1px solid #ccc">{{$user->id}}</td>
                                    <td style="border:1px solid #ccc">{{$user->name}}</td>
                                    <td style="border:1px solid #ccc">{{$user->email}}</td>
                                    <td style="border:1px solid #ccc">{{$user->created_at}}</td>
                                </tr>
                            </table>--}}
                            <ul>
                                <li class="user_mes">id <div style="display:none">{{$user->id}}</div></li>
                                <li class="user_mes">name <div style="display:none">{{$user->name}}</div></li>
                                <li class="user_mes">email <div style="display:none">{{$user->email}}</div></li>
                                <li class="user_mes">created_at <div style="display:none">{{$user->created_at}}</div></li>
                            </ul>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection