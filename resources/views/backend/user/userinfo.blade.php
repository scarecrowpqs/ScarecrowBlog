@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">
            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    用户名:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="userName" value="{{$userInfo['username']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    密码:
                </div>

                <div class="layui-col-md3">
                    <input type="password" class="layui-input" id="userPwd">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    头像地址:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="imageUrl"  value="{{$userInfo['imgurl']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    邮箱:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="email"  value="{{$userInfo['email']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset4 layui-col-md4 showTitle">
                    <a href="" class="layui-btn" style="width: 80%;" id="updateBtn">确 定</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        layui.use(['layer', 'form'], function(){
            var layer = layui.layer;
            var form = layui.form;

            $("#updateBtn").click(function (){
                var userName = $("#userName").val();
                var userPwd = $("#userPwd").val();
                var imageUrl = $("#imageUrl").val();
                var email = $("#email").val();

                if (userName == "") {
                    layer.msg("用户名不能为空!");
                    return ;
                }

                var data = {
                    userName:userName,
                    userPwd:userPwd,
                    imageUrl:imageUrl,
                    email:email,
                    uid:'{{$uid}}'
                };

                var url = '{{asset("back/changeuserinfo")}}';
                $.ajax({
                    url:url,
                    dataType:'JSON',
                    type:'POST',
                    data:data,
                    success:function(datas) {
                        if (datas.status == "YES") {
                            layer.msg(datas.info, {anim: 0}, function() {
                                window.location.render();
                            });
                        } else {
                            layer.msg(datas.info);
                        }
                    },
                    error:function() {
                        layer.msg("服务器连接失败");
                    }
                });
            });
        });

    </script>
@endpush

@push('styles')
    <style>
        .fromContent{
            display: block;
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }

        .showTitle{
            text-align: right;
            line-height: 38px;
            font-size: 20px;
            padding-right: 15px;
        }

        .showLine{
            margin-top: 20px;
        }
    </style>
@endpush