{{--管理文章--}}
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
        <table id="showWeiYuTable" lay-filter="test"></table>
    </div>
@endsection

@push('scripts')
    <script>
        layui.use(['layer', 'table'], function(){
            layer = layui.layer;
            table = layui.table;

            var tableIndex = table.render({
                elem: '#showWeiYuTable'
                ,url: '{{asset("back/api/article/getarticlelistpage")}}' //数据接口
                ,page: true //开启分页
                ,limit:15
                ,where:{sc:$("#searchContent").val()}
                ,cols: [[ //表头
                    {field: 'id', width: "5%", title: 'ID'}
                    ,{field: 'cateName', width: "10%",title: '分类'}
                    ,{field: 'title', width: "48%",title: '标题'}
                    ,{field: 'createTime', width: "15%",title: '发布时间'}
                    ,{field: 'author', width: "10%",title: '作者'}
                    ,{field: '', title: '操作', width: "12%",templet: function(d){
                        var str = "<a class='layui-btn layui-btn-sm' style='color:white;' onclick='edit(\""+ d.id +"\")'>编辑</a>";
                        str += "<a class='layui-btn layui-btn-sm layui-btn-danger' style='color:white;' onclick='deleteWeiYu(\""+ d.id +"\")'>删除</a>";
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

        function edit(id) {
            var index = layer.open({
                type: 2,
                title:"编辑文章",
                content: '{{asset("back/article/editarticle")}}?id=' + id,
                end:function() {
                    $("#searchBtn").click();
                }
            });
            layer.full(index);
        }

        /**
         * 删除数据
         * @param id
         */
        function deleteWeiYu(id){
            var url = '{{asset("back/api/article/deletearticle")}}?id=' + id;
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