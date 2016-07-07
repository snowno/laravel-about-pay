<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Learn Laravel 5</title>

    <link href="//cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<div id="content" style="padding: 50px;">

    <h4>
        <a href="/public/index.php/ins"><< 返回首页</a>
    </h4>

    <h1 style="text-align: center; margin-top: 50px;">{{ $inss->title }}</h1>
    <hr>
    <div id="date" style="text-align: right;">
        {{ $inss->updated_at }}
    </div>
    <div id="content" style="margin: 20px;">
        <p>
            {{ $inss->content }}
        </p>
    </div>

    <div id="comments" style="margin-top: 50px;">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>操作失败</strong> 输入不符合要求<br><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif

        <div id="new">



                    <img src="{{'/app/storage/uploads/'.$inss->image}}" class="form" style="width: 300px;">


        </div>

    </div>

</div>

</body>
</html>