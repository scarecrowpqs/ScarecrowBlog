{{--添加音乐--}}
@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md3 showTitle">
                    音乐名称:
                </div>

                <div class="layui-col-md5">
                    <input type="text" class="layui-input" id="musicName">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md3 showTitle">
                    音乐地址:
                </div>

                <div class="layui-col-md5">
                    <input type="text" class="layui-input" id="musicUrl">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md3 showTitle">
                    作者:
                </div>

                <div class="layui-col-md5">
                    <input type="text" class="layui-input" id="musicAuthor">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md3 showTitle">
                    音乐专辑图片地址:
                </div>

                <div class="layui-col-md5">
                    <input type="text" class="layui-input" id="imageUrl">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset4 layui-col-md4 showTitle">
                    <a class="layui-btn" style="width: 80%;" id="addBtn">确 定</a>
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

            $("#addBtn").click(function (){
                var musicName = $("#musicName").val();
                var musicUrl = $("#musicUrl").val();
                var musicAuthor = $("#musicAuthor").val();
                var imageUrl = $("#imageUrl").val();

                if (musicUrl == "") {
                    layer.msg("音乐地址不能为空!");
                    return false;
                }

                var data = {
                    musicName:musicName,
                    musicUrl:musicUrl,
                    musicAuthor:musicAuthor,
                    imageUrl:imageUrl
                };

                var url = '{{asset("back/api/music/add")}}';
                $.ajax({
                    url:url,
                    dataType:'JSON',
                    type:'POST',
                    data:data,
                    success:function(datas) {
                        if (datas.status == "YES") {
                            layer.msg(datas.info, {anim:0}, function() {
                                window.location.reload();
                            })
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