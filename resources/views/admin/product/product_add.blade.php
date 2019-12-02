@extends('admin.master')

@section('content')
    <style type="text/css">
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
                    商品名称
                </label>
                <div class="layui-input-inline">
                    <input type="text"  name="name" lay-verify="required"
                           autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="" class="layui-form-label">
                    选择分类
                </label>
                <div class="layui-input-inline">
                    <select name="category_id" lay-verify="required">
                        <option value="">请选择分类</option>
                        @forelse($categorys as $item)
                            <option value="{{$item['id']}}" >{{$item['name']}}</option>
                            @if(isset($item['_child']))
                                @foreach($item['_child'] as $item2)
                                    <option value="{{$item2['id']}}"}} >&nbsp;&nbsp;┗━━{{$item2['name']}}</option>
                                    @if(isset($item2['_child']))
                                        @foreach($item2['_child'] as $item3)
                                            <option value="{{$item3['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{$item3['name']}}</option>
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
                <label for="" class="layui-form-label">商品价格</label>
                <div class="layui-input-inline">
                    <input type="text"  name="price" required="" lay-verify="number|required"
                           autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">是否在售</label>
                <div class="layui-input-inline">
                    <input type="radio" name="on_sale" value="1" title="在售" checked>
                    <input type="radio" name="on_sale" value="0" title="下架" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">商品平均评分</label>
                <div class="layui-input-inline">
                    <input type="text"  name="rating" required="" lay-verify="number"
                           autocomplete="off" class="layui-input" value="">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">库存</label>
                <div class="layui-input-inline">
                    <input type="text"  name="stock" required="" lay-verify="number"
                           autocomplete="off" class="layui-input" value="{{$product_data->stock}}">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">销量</label>
                <div class="layui-input-inline">
                    <input type="text"  name="sold_count" required="" lay-verify="number"
                           autocomplete="off" class="layui-input" value="">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">商品描述</label>
                <div class="layui-input-inline">
                    <textarea name="description" id="" class="layui-textarea"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_nickname" class="layui-form-label">
                    封面图片
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
                <label for="" class="layui-form-label">商品详情图片</label>
                <div class="layui-input-block">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                            预览图：
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box" class="layui-clear">
                                </ul>
                            </div>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="product_add" lay-submit="">
                    添加商品
                </button>
                <button type="button" class="layui-btn"  onclick="x_admin_close()">
                    返回
                </button>
            </div>
            {{csrf_field()}}
        </form>
    </div>

@endsection

@section('my-js')
    <script>
        layui.use(['form','layer','upload'],function () {
            var form = layui.form
                ,layer = layui.layer;
            var upload = layui.upload;

            //监听提交
            form.on('submit(product_add)',function(data){
                var arr = {};
                $("input:hidden[name='image_src']").each(function(i) {
                    arr[i] = $(this).val();
                });
                data.field.image_src = arr;

                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'/admin/product_add',
                    data:data.field,
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
                });

            });

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

            //多图片上传
            upload.render({
                elem: '#uploadPic'
                ,url: '/uploadImg/'
                ,multiple: true
                ,size:10*1024*1024
                ,data:{"_token":"{{ csrf_token() }}"}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){

                    });
                }
                ,done: function(res){
                    //上传完毕
                    //如果上传失败
                    if(res.code == 0){
                        $('#layui-upload-box').append('<li id="'+res.imageId+'" image_name="'+res.name+'"><i class="layui-icon layui-icon-delete"  onclick="UPLOAD_IMG_DEL('+res.imageId+')"></i><img src="'+res.url+'"/><p>上传成功</p>'+'<input type="hidden"  name="image_src"  value="'+res.url+'">'+'</li>')

                    }
                    return layer.msg(res.msg);
                }
            });
        });
        /*
        删除上传图片
        */
        function UPLOAD_IMG_DEL(lis) {
            var image_name =$("#"+lis).attr('image_name');
            $.ajax({
                url:'/deleteImg',
                type:'post',
                data:{image_name:image_name,_token:"{{csrf_token()}}"},
                success:function (result) {
                    if(result.code!=0){
                        layui.layer.msg('删除失败');
                    }else{
                        layui.layer.msg('删除成功');
                        $("#"+lis).remove();
                    }
                }
            });

        }


    </script>
@endsection