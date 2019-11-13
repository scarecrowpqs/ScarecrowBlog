<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="max-age=72000" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="baidu-site-verification" content="yRcfVm8xYb" />
    <title>Scarecrow 博客</title>
    <meta name="keywords" content="scarecrow,blog,ScarecrowBlog,博客,Scarecrow博客,{{$metaKey ?? ''}}"/>
    <meta name="description" content="{{$description ?? 'code changing word!'}}"/>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="{{asset('assets/plugins/animate/animate.min.css')}}" rel="stylesheet">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{asset('assets/plugins/icomoon/icomoon.css')}}">
    <link href="{{asset('assets/plugins/bootstrap/src/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/flexslider/flexslider.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/common/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/jquery/css/jquery.notifyBar.css')}}"/>
    <link href="{{asset('assets/plugins/normalize/normalize.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/nprogress/nprogress.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery/jquery.pjax.min.js')}}"></script>
    <script src="{{asset('assets/plugins/nprogress/nprogress.min.js')}}"></script>
</head>
<body>
<div id="fh5co-page">
    <input type="hidden" id="basePath" value="{{asset("/")}}">
    <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
    <aside id="fh5co-aside" role="complementary" class="border js-fullheight">
        <h1 id="fh5co-logo" style="font-size:25px"><a href="{{$commonData['首页链接']??'#'}}">Scarecrow博客</a></h1>
        <div style="margin-bottom: 1em;text-align: center;">
            <input type="text" class="searchInput" placeholder="Search" id="searchInput" value="{{$sc ?? ''}}">
        </div>
        <nav id="fh5co-main-menu" role="navigation">
            <ul>
                <li><a href="{{asset('/home')}}" style="font-size:16px">首页</a></li>
                <li><a href="{{asset('/recommend')}}" style="font-size:16px">推荐</a></li>
                <li><a href="{{asset('/link')}}" style="font-size:16px">邻居</a></li>
                <li><a href="{{asset('/weiyu')}}" style="font-size:16px">说说</a></li>
                <li><a href="{{asset('/about')}}" style="font-size:16px">关于</a></li>
            </ul>
        </nav>
        <div class="fh5co-footer">
            <img src="{{asset('assets/frontend/images/greetgif') . '/' . \Scarecrow\showGreet()}}" style="width:150px"><br /><span style="background: linear-gradient(to right, #FF0000, #0000FF);-webkit-background-clip: text;color: transparent;">择一人到白头</span><br />
            <p> Copyright &copy; 2019 By Scarecrow </p>
            <ul>
                <li><a href="#">QQ：1366635163</a></li>
            </ul>
        </div>
    </aside>
</div>