@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">ins updates    <button><a href="{{url('ins/create')}}">create</a></button></div>

                    <div class="panel-body">
                        <div>
                        @foreach($inss as $ins)
                            <div>
                                <div> <a href="{{ url('ins/detail/'.$ins->id) }}" ><img src="{{'/app/storage/uploads/'.$ins->image}}" width="50" height="50"></a></div>
                                <a href="{{ url('ins/detail/'.$ins->id) }}" >{{$ins->title}}</a>
                                <br>
                                    @foreach($ins->tag as $tag)
                                    <a href="{{url('ins/tags/'.$tag.'/'.$ins->id )}}">{{$tag}}</a>
                                    @endforeach
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection