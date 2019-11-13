<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>ScarecrowBlog 后台管理</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('assets/plugins/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/font.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/xadmin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/theme4.css')}}">
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/backend/js/xadmin/xadmin.js')}}"></script>

</head>
<body class="index">
<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="{{asset('back/index')}}">ScarecrowBlog 后台管理</a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item to-index">
            <a href="/home" target="_blank">前台首页</a></li>

        <li class="layui-nav-item">
            <a href="javascript:;">{{\Scarecrow\getLoginUserInfo('username')}}</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('个人信息', '{{asset("back/showuserinfo")}}')">个人信息</a>
                </dd>
                <dd>
                    <a onclick="loginOut()">退出</a>
                </dd>
            </dl>
        </li>

    </ul>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home">
                <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd></dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{asset('back/home')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
        <div id="tab_show"></div>
    </div>
</div>
<div class="page-content-bg"></div>
<style id="theme_style"></style>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->

<script>
    // 是否开启刷新记忆tab功能
    var is_remember = true;
    {{--getMenuApiUrl = '{{asset("back/getmenulist")}}';--}}

    function loginOut(){
        var url = '{{asset("/back/loginout")}}';
        $.get(url, function (datas){
            if (datas.status == "YES") {
                layer.msg(datas.info,{anim:0}, function() {
                    window.location.reload();
                });
            } else {
                layer.msg(datas.info);
            }
        }, 'json');
    }
</script>
<script type="text/javascript" src="{{asset('assets/backend/js/xadmin/index.js')}}"></script>
</body>
</html>