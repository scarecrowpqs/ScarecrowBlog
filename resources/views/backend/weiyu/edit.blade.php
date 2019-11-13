{{--发布微语--}}
@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">
            <div class="layui-row showLine">
                <div class="layui-col-xs-offset2 layui-col-xs2 showTitle">
                    内容:
                </div>

                <div class="layui-col-xs4">
                    <textarea id="weiyuContent" placeholder="请输入内容" class="layui-textarea">{{$data['content']}}</textarea>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset2 layui-col-xs2 showTitle">
                    是否公开:
                </div>

                <div class="layui-col-xs4">
                    <select id="isGk" lay-verify="required">
                        <option value="1" {{$data['status'] == 1 ? 'selected' : ''}}>是</option>
                        <option value="2" {{$data['status'] == 2 ? 'selected' : ''}}>否</option>
                    </select>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset4 layui-col-xs4 showTitle">
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
                var weiyuContent = $("#weiyuContent").val();
                var isGk = $("#isGk").val();

                if (weiyuContent == "") {
                    layer.msg("微语内容不能为空!");
                    return false;
                }

                var data = {
                    weiyuContent:weiyuContent,
                    isGk:isGk,
                    id:'{{$data['id']}}'
                };

                var url = '{{asset("back/api/weiyu/editdata")}}';
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