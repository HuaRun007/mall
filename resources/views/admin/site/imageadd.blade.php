@extends('admin.master')

@section('content')
    <style>
        #layui-upload-box li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box li img{
            width: 100%;
        }
        #layui-upload-box li p{
            width: 100%;
            height: 22px;
            font-size: 12px;
            position: absolute;
            left: 0;
            bottom: 0;
            line-height: 22px;
            text-align: center;
            color: #fff;
            background-color: #333;
            opacity: 0.6;
        }
        #layui-upload-box li i{
            display: block;
            width: 20px;
            height:20px;
            position: absolute;
            text-align: center;
            top: 2px;
            right:2px;
            z-index:999;
            cursor: pointer;
        }
    </style>
    <div class="x-body">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_nickname" class="layui-form-label">
                    图片
                </label>
                <div class="layui-input-inline">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box" class="layui-clear">

                                </ul>
                                <input type="hidden" value="" id="image_path" name="image_path">
                            </div>
                        </div>
                </div>

            </div>
            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">
                    排序
                </label>
                <div class="layui-input-inline">
                    <input type="number" name="sort" value="{{ $advert->sort ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    添加
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer','upload'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer,upload = layui.upload;

            //单图片上传
            upload.render({
                elem: '#uploadPic'
                ,url: '/uploadImg/'
                ,multiple: false
                ,size:10*1024*1024
                ,data:{"_token":"{{ csrf_token() }}"}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });
                }
                ,done: function(res){
                    //上传完毕
                    //如果上传失败
                    //如果上传失败
                    if(res.code == 0){
                        $("#image_path").val(res.url);
                        $('#layui-upload-box li p').text('上传成功');
                        return layer.msg(res.msg);
                    }
                    return layer.msg(res.msg);
                }
            });


            //监听提交
            form.on('submit(add)', function(data){

                //发异步，把数据提交给php
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'/admin/siteimage/add',
                    data:{data:data.field,_token:"{{csrf_token()}}"},
                    success:function (result) {
                        if(result.code!=0){
                            layer.alert(result.message, {icon: 5},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                window.parent.location.reload();
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                            return false;
                        }else{
                            layer.alert(result.message, {icon: 6},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                window.parent.location.reload();
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                            return false;
                        }
                    },
                    error:function () {

                    }
                });

                return false;
            });


        });
    </script>

@endsection