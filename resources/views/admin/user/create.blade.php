@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form" id="user_create_form" >
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    用户名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="username"  lay-verify="required"
                           autocomplete="off" class="layui-input" value="{{old('username')}}">
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
                    <input type="text" id="L_name" name="name" lay-verify="required"
                           autocomplete="off" class="layui-input" value="{{old('name')}}">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">
                    手机号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_phone" name="phone" lay-verify="required|phone"
                           autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    邮箱号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" lay-verify="required|email"
                           autocomplete="off" class="layui-input" value="">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_status" class="layui-form-label">
                    状态
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox"    lay-skin="switch" lay-text="启用|禁用"
                           lay-filter="member_edit_switch"  checked >
                    <input type="hidden" name="status" id="L_status" value="1" >
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_password" class="layui-form-label">
                    密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_password" name="password"  lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass"  lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="user_add" lay-submit="">
                    添加管理员
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            form.on('switch(member_edit_switch)', function (){
                $('#L_status').val(this.checked ? 1 : 0);
            });


            form.on('submit(user_add)',function(data){
                var pwd = $(':input[name=password]').val();
                var repwd = $(':input[name=repass]').val();
                if(pwd != repwd){
                    layer.alert('两次密码输入不一致', {icon: 5});
                    return false;
                }

                $.ajax({
                    type:'POST',
                    url: '/admin/user_store',
                    data:{data:data.field,_token:"{{csrf_token()}}"},
                    dataType:'json',
                    success:function (result) {
                        if(result.code == 0){
                            layer.alert(result.msg, {icon: 6},function () {
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                                x_admin_father_reload();
                                return false;
                            });
                        }else{
                            layer.alert(result.msg, {icon: 5});
                        }
                    }
                });
            });

        });
    </script>

@endsection