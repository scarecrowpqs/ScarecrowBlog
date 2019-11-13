<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="baidu-site-verification" content="yRcfVm8xYb" />
    <title>Scarecrow 博客</title>
    <meta name="keywords" content="scarecrow,blog,ScarecrowBlog,博客,Scarecrow博客"/>
    <meta name="description" content="code changing word!"/>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{asset('assets/plugins/layui/css/layui.css')}}">
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/layui/layui.js')}}"></script>
    @stack('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>