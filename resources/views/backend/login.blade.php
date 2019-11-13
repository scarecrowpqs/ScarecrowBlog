<!DOCTYPE html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>ScarecrowBlog 后台管理</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/font.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/xadmin/xadmin.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/layui/css/layui.css')}}">
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/layui/layui.js')}}"></script>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">ScarecrowBlog 后台管理</div>
    <div id="darkbannerwrap"></div>

    <div class="layui-form" >
        <input name="userName" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
        <hr class="hr15">
        <input name="userPassword" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="button" id="login">
        <hr class="hr20" >
    </div>
</div>

<script>
    $(function  () {
        layui.use('form', function(){
            var form = layui.form;
            form.on('submit(login)', function(datas){
                var data = datas.field;
                $.ajax({
                    url:'{{asset("/back/api/login")}}',
                    type:'POST',
                    dataType:'JSON',
                    data:data,
                    success:function(datas) {
                        if (datas.status == "YES") {
                            layer.msg(datas.info, {anim: 0}, function() {
                                window.location.href = '{{asset("/back/index")}}';
                            });
                        } else {
                            layer.msg(datas.info);
                        }
                    },
                    error:function() {
                        layer.msg("服务器连接失败");
                    }
                });
                return false;
            });
        });

        $(document).keyup(function(event){
            if(event.keyCode ==13){
                $("#login").trigger("click");
            }
        });
    })
</script>
<!-- 底部结束 -->
<script type="text/javascript" src="//js.users.51.la/20419633.js"></script>
</body>
</html>