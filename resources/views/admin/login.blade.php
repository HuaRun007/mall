@extends('admin.master')

@section('content')
    <body class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="message">多复用商城V1.0-管理登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="button">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        layui.use('form', function(){
            var form = layui.form;
            var layer = layui.layer;
            // layer.msg('玩命卖萌中', function(){

            //   });
            //监听提交
            form.on('submit(login)', function(data){
                var username = data.field.username;
                var password = data.field.password;
                $.ajax({
                    type:'post',
                    url:'/admin/login',
                    data:{username:username,password:password,_token:"{{csrf_token()}}" },
                    dataType:'json',
                    success:function (json) {
                        if(json.code !=0){

                            layer.msg(json.message);
                        }else{

                            layer.msg(json.message);
                            setTimeout(function () {
                                location.href='/admin/'
                            },800);

                        }
                    },
                    error:function (xhr,status, message) {
                        console.log(xhr);
                        console.log(status);
                        console.log(message);
                    }
                });

            });
        });



    </script>
    </body>
@endsection