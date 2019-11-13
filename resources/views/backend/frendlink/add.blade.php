{{--发布友链--}}
@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">
            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    友链分组:
                </div>

                <div class="layui-col-md3">
                    <select id="linkGroup" lay-verify="required">
                        @foreach($allGroup as $k => $item)
                            <option value="{{$k}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    友链名称:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="linkName">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    友链地址:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="linkUrl">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    头像地址:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="imageUrl">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset2 layui-col-md3 showTitle">
                    博客介绍:
                </div>

                <div class="layui-col-md3">
                    <input type="text" class="layui-input" id="linkJieShao">
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
                var linkGroup = $("#linkGroup").val();
                var linkName = $("#linkName").val();
                var linkUrl = $("#linkUrl").val();
                var imageUrl = $("#imageUrl").val();
                var linkJieShao = $("#linkJieShao").val();

                if (linkName == "") {
                    layer.msg("友链内容不能为空!");
                    return false;
                }

                if (linkUrl == "") {
                    layer.msg("友链地址不能为空!");
                    return false;
                }


                var data = {
                    linkGroup:linkGroup,
                    linkName:linkName,
                    linkUrl:linkUrl,
                    imageUrl:imageUrl,
                    linkJieShao:linkJieShao
                };

                var url = '{{asset("back/api/frendlink/add")}}';
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