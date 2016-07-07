@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <ul>
                    @foreach($articles as $article)
                        <li>
                            <div><a href="{{ url('article/'.$article->id) }}"><span>{{$article->title}}</span></a></div>
                            <div>

                                <p>{{$article->content}}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    {!!$articles->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
