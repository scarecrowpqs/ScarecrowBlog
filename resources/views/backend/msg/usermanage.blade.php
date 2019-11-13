{{--管理留言--}}
@extends('backend.common.pagebase')

@section('content')
    <div style="width: 95%;margin: auto;margin-top: 20px;">
        <div class="layui-row">
            <div class="layui-col-md-offset9 layui-col-md2">
                <input type="text" class="layui-input" placeholder="输入内容搜索" id="searchContent">
            </div>
            <div class="layui-col-md1">
                <button class="layui-btn" style="width: 100%;" id="searchBtn">搜索</button>
            </div>
        </div>
        <table id="showMsgTable" lay-filter="test"></table>
    </div>
@endsection

@push('scripts')
    <script>
        layui.use(['layer', 'table','form'], function(){
            layer = layui.layer;
            table = layui.table;
            form = layui.form;

            var tableIndex = table.render({
                elem: '#showMsgTable'
                ,url: '{{asset("back/api/msg/getmsguserlistpage")}}' //数据接口
                ,page: true //开启分页
                ,limit:15
                ,where:{sc:$("#searchContent").val()}
                ,cols: [[ //表头
                    {field: 'uid',width:'8%', title: 'ID'}
                    ,{field: 'nickname', title: '昵称'}
                    ,{field: 'email', title: '邮箱'}
                    ,{field: 'homeurl', title: '用户首页地址'}
                    ,{field: 'imgurl', title: '用户头像地址'}
                    ,{field: '', title: '评论',width:'8%', templet: function(d){
                        var str = '<input type="checkbox" lay-skin="switch" lay-text="ON|OFF" ' + (d.status == 1 ? 'checked' : '') + '>';
                        return str;
                    }}
                    ,{field: 'cdat', title: '创建时间'}
                    ,{field: '', title: '操作', templet: function(d){
                        if (d.status == 1) {
                            var str = "<a class='layui-btn layui-btn-sm layui-btn-danger' style='color:white;' onclick='changeState(\""+ d.uid +"\")'>禁止</a>";
                        } else {
                            var str = "<a class='layui-btn layui-btn-sm' style='color:white;' onclick='changeState(\""+ d.uid +"\")'>允许</a>";
                        }

                        str += "<a class='layui-btn layui-btn-sm layui-btn-danger' style='color:white;' onclick='deleteMsgUser(\""+ d.uid +"\")'>删除</a>";
                        return str;
                    }}
                ]]
                ,response: {
                    statusName: 'status' //规定数据状态的字段名称，默认：code
                    ,statusCode: "YES" //规定成功的状态码，默认：0
                    ,msgName: 'info' //规定状态信息的字段名称，默认：msg
                    ,countName: 'total' //规定数据总数的字段名称，默认：count
                    ,dataName: 'data' //规定数据列表的字段名称，默认：data
                },
                text: {
                    none: '暂无相关数据'
                }
            });


            $("#searchBtn").click(function(){
                tableIndex.reload({
                    where: {
                        sc: $("#searchContent").val()
                    }
                    ,page: {
                        curr: 1
                    }
                });
            });
        });

        /**
         * 删除数据
         * @param id
         */
        function deleteMsgUser(id){
            var url = '{{asset("back/api/msg/deletemsguser")}}?id=' + id;
            $.get(url, function (datas){
                if (datas.status == 'YES') {
                    layer.msg(datas.info, {anim:0}, function(){
                        $("#searchBtn").click();
                    });
                } else {
                    layer.msg(datas.info);
                }
            }, 'json');
        }

        function changeState(id) {
            var url = '{{asset("back/api/msg/changemsguserstatus")}}?id=' + id;
            $.get(url, function (datas){
                if (datas.status == 'YES') {
                    layer.msg(datas.info, {anim:0}, function(){
                        $("#searchBtn").click();
                    });
                } else {
                    layer.msg(datas.info);
                }
            }, 'json');
        }
    </script>
@endpush

@push('styles')
    <style>

    </style>
@endpush