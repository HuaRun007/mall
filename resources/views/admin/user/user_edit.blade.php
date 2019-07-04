@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form" >
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    用户名
                </label>
                <div class="layui-input-inline">
                    <input type="hidden" name="user_id" value="{{$user_data->id}}">
                    <input type="text" id="L_username" name="username" required="" lay-verify="username"
                           autocomplete="off" class="layui-input" value="{{$user_data->username ?? old('username') }}">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    昵称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_name" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$user_data->name ?? old('name')}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">
                    手机号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_phone" name="phone" required=""
                           autocomplete="off" class="layui-input" value="{{$user_data->phone}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    邮箱号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" required=""
                           autocomplete="off" class="layui-input" value="{{$user_data->email}}">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_status" class="layui-form-label">
                    状态
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox"    lay-skin="switch" lay-text="启用|禁用"
                           lay-filter="member_edit_switch" {{$user_data->status==1 ?  'checked' : ''}}>
                    <input type="hidden" name="status" id="L_status" value="{{$user_data->status}}" >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_password" class="layui-form-label">
                    密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_password" name="password"  lay-verify="password"
                           autocomplete="off" class="layui-input">
                </div>

            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass"  lay-verify="repass"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="user_edit" lay-submit="">
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

            form.on('switch(member_edit_switch)', function (data){
                $('#L_status').val(this.checked ? 1 : 0);
            });

            //监听提交
            form.on('submit(user_edit)', function(data){
                //发异步，把数据提交给php
                var request_data = data.field;
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'/admin/user_update',
                    data:{user_id:request_data.user_id,username:request_data.username,name:request_data.name,phone:request_data.phone,
                        email:request_data.email,status:request_data.status,password:request_data.password,repass:request_data.repass,_token:"{{csrf_token()}}"},
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