<!DOCTYPE html>
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
    <script type="text/javascript" src="{{asset('assets/backend/js/xadmin/index.js')}}"></script>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <blockquote class="layui-elem-quote">欢迎管理员：
                        <span class="x-red">{{\Scarecrow\getLoginUserInfo('username')}}</span>！当前时间:{{date("Y-m-d H:i:s")}}
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">数据统计</div>
                <div class="layui-card-body ">
                    <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>文章数</h3>
                                <p>
                                    <cite>{{$baseInfo['articleNum']}}</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>留言数</h3>
                                <p>
                                    <cite>{{$baseInfo['liuyanNum']}}</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>微语数</h3>
                                <p>
                                    <cite>{{$baseInfo['wyNum']}}</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6 ">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>友链数</h3>
                                <p>
                                    <cite>{{$baseInfo['linkNum']}}</cite></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <tr>
                            <th>ScarecrowBlog 博客</th>
                            <td>{{$baseInfo['appVersion']}}</td></tr>
                        <tr>
                            <th>服务器地址</th>
                            <td>{{$baseInfo['serverUri']}}</td></tr>
                        <tr>
                            <th>操作系统</th>
                            <td>{{$baseInfo['systemType']}}</td></tr>
                        <tr>
                            <th>运行环境</th>
                            <td>{{$baseInfo['runHj']}}</td></tr>
                        <tr>
                            <th>PHP版本</th>
                            <td>{{$baseInfo['phpVersion']}}</td></tr>
                        <tr>
                            <th>MYSQL版本</th>
                            <td>{{$baseInfo['mysqlVersion']}}</td></tr>
                        <tr>
                            <th>Laravel5.8</th>
                            <td>5.8</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">开发团队:Scarecrow</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <tr>
                            <th>版权所有</th>
                            <td>Scarecrow
                                <a href="http://blog.scarecrow.top" target="_blank">访问官网</a></td>
                        </tr>
                        <tr>
                            <th>开发者</th>
                            <td>Scarecrow(1366635163@qq.com)</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <style id="welcome_style"></style>
</div>
</div>
</body>
</html>