@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form" >
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    角色
                </label>
                <div class="layui-input-inline">
                    <input type="hidden" name="role_id" value="{{$role_data->id}}">
                    <input type="text" id="L_name" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$role_data->name ?? old('name') }}" {{ $role_data->name=='root' ? 'readonly' : '' }} >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_display_name" class="layui-form-label">
                    显示名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_display_name" name="display_name" required="" lay-verify="display_name"
                           autocomplete="off" class="layui-input" value="{{$role_data->display_name ?? old('display_name')}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_description" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-inline">
                        <textarea name="description" class="layui-textarea">{{$role_data->description ?? old('description')}}</textarea>
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="role_edit" lay-submit="">
                    更新
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            //监听提交
            form.on('submit(role_edit)', function(data){
                //发异步，把数据提交给php
                var request_data = data.field;
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'/admin/role_update',
                    data:{role_id:request_data.role_id,name:request_data.name,display_name:request_data.display_name,description:request_data.description,_token:"{{csrf_token()}}"},
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

            form.on('submit',function () {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                window.parent.location.reload();
                //关闭当前frame
                parent.layer.close(index);
            });


        });
    </script>

@endsection