{{--发布文章--}}
@extends('backend.common.pagebase')

@section('content')
    <div class="fromContent">
        <div class="layui-form layui-fluid">
            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章分类
                </div>

                <div class="layui-col-md8">
                    <select id="categoryId" lay-verify="required">
                        @foreach($allCategoryList as $k => $item)
                            <option value="{{$k}}" {{$articleInfo['cid'] == $k ? "selected" : ''}}>{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章标题
                </div>

                <div class="layui-col-md8">
                    <input type="text" class="layui-input" id="articleTitle" value="{{$articleInfo['title']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章封面
                </div>

                <div class="layui-col-md8">
                    <div style="width: 380px;height: 200px;display: block;border: 1px solid #C7C7C7;">
                        <img src="{{$articleInfo['imgurl'] ? : DEFAULT_IMG_FM}}" alt="" width="100%" height="100%" id="showImg">
                        <input type="file" name="upfile" id="uploadImg" style="visibility: hidden;">
                    </div>
                    <div style="margin-top: 5px;">
                        <button class="layui-btn" id="selectImgBtn">选择图片</button>
                    </div>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    SEO关键词(,隔开)
                </div>

                <div class="layui-col-md8">
                    <input type="text" class="layui-input" id="keyword" value="{{$articleInfo['keyword']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    SEO描述
                </div>

                <div class="layui-col-md8">
                    <input type="text" class="layui-input" id="description" value="{{$articleInfo['description']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章阅读数
                </div>

                <div class="layui-col-md8">
                    <input type="text" class="layui-input" id="readNum" value="{{$articleInfo['readnum']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章作者
                </div>

                <div class="layui-col-md8">
                    <input type="text" class="layui-input" id="articleUser"  value="{{$articleInfo['author']}}">
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章摘要
                </div>

                <div class="layui-col-md8">
                    <textarea id="articleZhaiyao" placeholder="请输入内容" class="layui-textarea">{{$articleInfo['remark']}}</textarea>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    是否公开
                </div>

                <div class="layui-col-md8">
                    <input type="radio" name="isGk" value="YES" title="YES" lay-filter="isGkYes" {{$articleInfo['openlevel'] == 1 ? 'checked' : ''}}>
                    <input type="radio" name="isGk" value="NO" title="NO" lay-filter="isGkNo" {{$articleInfo['openlevel'] == 2 ? 'checked' : ''}}>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    是否推荐
                </div>

                <div class="layui-col-md8">
                    <input type="radio" name="isTj" value="YES" title="YES" lay-filter="isTjYes" {{$articleInfo['recommend'] == 1 ? 'checked' : ''}}>
                    <input type="radio" name="isTj" value="NO" title="NO" lay-filter="isTjNo" {{$articleInfo['recommend'] == 2 ? 'checked' : ''}}>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset1 layui-col-md2 showTitle">
                    文章内容
                </div>

                <div class="layui-col-md8">
                    <div id="articleContent" style="width: 100%;height: 500px;"></div>
                </div>
            </div>

            <div class="layui-row showLine">
                <div class="layui-col-md-offset4 layui-col-md4 showTitle">
                    <a class="layui-btn" style="width: 80%;" id="updateBtn">确 定</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript"  src="{{asset('assets/plugins/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript"  src="{{asset('assets/plugins/ueditor/ueditor.all.js')}}"> </script>
    <script type="text/javascript"  src="{{asset('assets/plugins/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript"  src="{{asset('assets/plugins/scarecrowupload/ScarecrowPatchUpload.js')}}"></script>
    <script>
        var ueditorPhpUrl = '{{asset("back/article/ueditorphphandler")}}';
        window.UEDITOR_CONFIG['serverUrl'] = ueditorPhpUrl;
        //初始化富文本编辑框
        var ue = UE.getEditor('articleContent');

        layui.use(['layer', 'form'], function(){
            var layer = layui.layer;
            var form = layui.form;
            var isGk = '{{$articleInfo['openlevel']}}';
            var isTj = '{{$articleInfo['recommend']}}';


            $("#selectImgBtn").click(function() {
                var fileDiv = $("#uploadImg")[0];
                fileDiv.click();
                fileDiv.onchange = function() {
                    var allFileObj = this.files;
                    var fileObj = allFileObj[0];
                    if(!checkFileExt(fileObj.name)) {
                        layer.msg("文件格式不支持上传");
                        return ;
                    }

                    var imgData = window.URL.createObjectURL(fileObj);
                    $("#showImg").attr('src', imgData);
                }
            });

            form.on('radio(isGkYes)', function(data){
                isGk = 1;
            });

            form.on('radio(isGkNo)', function(data){
                isGk = 2;
            });

            form.on('radio(isTjYes)', function(data){
                isTj = 1;
            });

            form.on('radio(isTjNo)', function(data){
                isTj = 2;
            });

            $("#updateBtn").click(function() {
                var addAritcleUrl = '{{asset("back/api/article/updatearticle")}}';
                var categoryId = $("#categoryId").val();
                var articleTitle = $("#articleTitle").val();
                var uploadImg = $("#uploadImg")[0]['files'];
                var readNum = $("#readNum").val();
                var articleUser = $("#articleUser").val();
                var articleZhaiyao = $("#articleZhaiyao").val();
                var keyword = $("#keyword").val();
                var description = $("#description").val();
                var imgUrl = $("#showImg").attr('src');
                var articleContent = ue.getContent();

                var data = {
                    categoryId:categoryId,
                    articleTitle:articleTitle,
                    readNum:readNum,
                    articleUser:articleUser,
                    articleZhaiyao:articleZhaiyao,
                    articleContent:articleContent,
                    isGk:isGk,
                    isTj:isTj,
                    imgUrl:imgUrl,
                    aid:'{{$articleInfo["aid"]}}',
                    description:description,
                    keyword:keyword
                };

                if (uploadImg.length > 0) {
                    var url = '{{asset("back/article/ueditorphphandler")}}?action=uploadimage'
                    var upload = new ScarecrowPatchUpload(url);
                    upload.setFuncUploadSuccess(function (datas) {
                        var dataObj = JSON.parse(datas);
                        if (dataObj.state == 'SUCCESS') {
                            data['imgUrl'] = dataObj['url'];
                            $.post(addAritcleUrl,data, function(datas){
                                layer.msg(datas.info);
                                if (datas.status == "YES") {
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 1000);
                                }
                            }, 'json');
                        } else {
                            layer.msg(dataObj.state);
                        }

                    });
                    upload.setFuncUploadError(function() {
                        layer.msg("封面图片上传失败，请检查BUG.");
                    });
                    upload.addFile(uploadImg[0]);
                    upload.sendFile();
                } else {
                    $.post(addAritcleUrl,data, function(datas){
                        layer.msg(datas.info);
                        if (datas.status == "YES") {
                            setTimeout(function(){
                                window.location.reload();
                            }, 1000);
                        }
                    }, 'json');
                }
            });


            /**
             * 检查文件是否被允许上传
             * @param filename
             * @returns {boolean}
             */
            function checkFileExt(filename) {
                var flag = false;
                var arr = ["jpg","png","gif","jpeg"];
                var index = filename.lastIndexOf(".");
                var ext = filename.substr(index+1);
                for(var i=0;i<arr.length;i++)
                {
                    if(ext == arr[i])
                    {
                        flag = true;
                        break;
                    }
                }
                if (flag) {
                    return true;
                } else {
                    return false;
                }
            }

            ue.ready(function() {
                ue.setContent(`{!! $articleInfo['content'] !!}`);
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
            margin-bottom: 50px;
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