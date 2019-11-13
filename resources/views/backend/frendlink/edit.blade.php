{{--发布友链--}}
@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">
            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    友链分组:
                </div>

                <div class="layui-col-xs4">
                    <select id="linkGroup" lay-verify="required">
                        @foreach($allGroup as $k => $item)
                            <option value="{{$k}}" {{$k == $linkInfo['spread_id']  ? 'selected' : ''}}>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    友链名称:
                </div>

                <div class="layui-col-xs4">
                    <input type="text" class="layui-input" id="linkName" value="{{$linkInfo['title']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    友链地址:
                </div>

                <div class="layui-col-xs4">
                    <input type="text" class="layui-input" id="linkUrl" value="{{$linkInfo['url']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    头像地址:
                </div>

                <div class="layui-col-xs4">
                    <input type="text" class="layui-input" id="imageUrl" value="{{$linkInfo['pic']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    博客介绍:
                </div>

                <div class="layui-col-xs4">
                    <input type="text" class="layui-input" id="linkJieShao"  value="{{$linkInfo['texts']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    排序ID:
                </div>

                <div class="layui-col-xs4">
                    <input type="text" class="layui-input" id="sort"  value="{{$linkInfo['sort']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset1 layui-col-xs3 showTitle">
                    显示状态:
                </div>

                <div class="layui-col-xs4">
                    <select id="linkStatus" lay-verify="required">
                        <option value="1" {{$linkInfo['status'] == 1 ? 'selected' : ''}}>显示</option>
                        <option value="2" {{$linkInfo['status'] == 2 ? 'selected' : ''}}>隐藏</option>
                    </select>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-xs-offset4 layui-col-xs4 showTitle">
                    <a class="layui-btn" style="width: 80%;" id="updateBtn">确 定</a>
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
                var linkGroup = $("#linkGroup").val();
                var linkName = $("#linkName").val();
                var linkUrl = $("#linkUrl").val();
                var imageUrl = $("#imageUrl").val();
                var linkJieShao = $("#linkJieShao").val();
                var sort = $("#sort").val();
                var status = $("#linkStatus").val();

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
                    linkJieShao:linkJieShao,
                    sort:sort,
                    status:status,
                    id:'{{$linkInfo['id']}}'
                };

                var url = '{{asset("back/api/frendlink/updatedata")}}';
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