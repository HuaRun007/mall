@extends('admin.master')

@section('content')
    <style>
        #layui-upload-box2 li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box2 li img{
            width: 100%;
        }
        #layui-upload-box2 li p{
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
        #layui-upload-box2 li i{
            display: block;
            width: 30px;
            height:30px;
            position: absolute;
            text-align: center;
            top: 0px;
            right:0px;
            z-index:999;
            cursor: pointer;
            color: yellow;
        }
    </style>
    <div class="x-body">
        <form class="layui-form" >
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    父类
                </label>
                <div class="layui-input-inline">
                    <select name="parent_id" lay-verify="required">
                        <option value="">请选择父类</option>
                        <option value="0">一级分类</option>
                        @forelse($categorys as $item)
                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @if(isset($item['_child']))
                                @foreach($item['_child'] as $item2)
                                    <option value="{{$item2['id']}}">&nbsp;&nbsp;┗━━{{$item2['name']}}</option>
                                    @if(isset($item2['_child']))
                                        @foreach($item2['_child'] as $item3)
                                            <option value="{{$item3['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{$item3['name']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    分类名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_name" name="name" lay-verify="required"
                           autocomplete="off" class="layui-input" value=""   >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_nickname" class="layui-form-label">
                    分类图片
                </label>
                <div class="layui-input-inline">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="uploadPic2"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                        <div class="layui-upload-list" >
                            <ul id="layui-upload-box2" class="layui-clear">

                            </ul>
                            <input type="hidden" value="" id="preview" name="preview">
                        </div>
                    </div>
                </div>

            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="category_add" lay-submit="">
                    添加分类
                </button>
            </div>
        </form>
    </div>

@endsection

@section('my-js')
    <script>
        layui.use(['form','layer','upload'],function () {
            var form = layui.form
                ,layer = layui.layer;
            var upload = layui.upload;

            //单图片上传
            upload.render({
                elem: '#uploadPic2'
                ,url: '/uploadImg/'
                ,multiple: false
                ,size:10*1024*1024
                ,data:{"_token":"{{ csrf_token() }}"}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });
                }
                ,done: function(res){
                    //上传完毕
                    //如果上传失败
                    //如果上传失败
                    if(res.code == 0){
                        $("#preview").val(res.url);
                        $('#layui-upload-box2 li p').text('上传成功');
                        return layer.msg(res.msg);
                    }
                    return layer.msg(res.msg);
                }
            });
            //监听提交
            form.on('submit(category_add)',function(data){

                $.ajax({
                    type: 'post',
                    url : '/admin/category_add',
                    data: {data:data.field, _token:"{{csrf_token()}}"},
                    dataType : 'json',
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

                        return false;
                    }

                });
            });
        });
    </script>
@endsection