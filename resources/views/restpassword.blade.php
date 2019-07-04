@extends('info_base')

@section('title','修改密码')

@section('content')
    <!------------------------------Bott------------------------------>
    <link rel="stylesheet" type="text/css" href="/css/mygrxx.css" />
    <div class="Bott">
        <div class="wrapper clearfix">
            <div class="you fl">
                <h2>修改密码</h2>
                <form  onclick="{return false};" class="remima">
                    <p><span>原密码：</span><input name="password" type="password" placeholder="输入原密码" /></p>
                    <p class="op" style="color: red"></p>
                    <p><span>新密码：</span><input name="newpassword" type="password" placeholder="输入6位数新密码"/></p>
                    <p class="op" style="color: red"></p>
                    <p><span>重复新密码：</span><input name="newpassword_again" type="password" placeholder="请再次输入密码" /></p>
                    <p class="op" style="color: red"></p>
                    {{--<p><span>验证码：</span><input type="text" /><img src="/img/temp/code.jpg" alt="" /></p>--}}
                    {{--<p class="op">按右图输入验证码，不区分大小写</p>--}}
                    <input type="submit" onclick="_toPassword()" value="提交" />
                </form>
            </div>
        </div>
    </div>
@endsection

@section('my-js')
    <script>
        var label = false;
        function _toPassword() {
            $('.op').each(function(k,v){
               $(v).text('');
            });
            var member_id = "{{$member->id}}";
            var password = $(':input[name=password]').val();
            if (password==''){
                $($('.op')[0]).text('原密码不能为空！');

                return false;
            }
            var newpassword = $(':input[name=newpassword]').val();
            if (newpassword==''){
                $($('.op')[1]).text('新密码不能为空！');

                return false;
            }
            var newpassword_again = $(':input[name=newpassword_again]').val();
            if (newpassword_again==''){
                $($('.op')[2]).text('请再次确认密码！');

                return false;
            }

            if (newpassword_again!=newpassword){
                $($('.op')[2]).text('两次密码不一致！');

                return false;
            }
            label = pasword_confirm(member_id,password);
            if (!label){
               $($('.op')[0]).text('原密码错误！');

                return false;
            }

            $.ajax({
                url:'/service/changepassword',
                type:'post',
                data:{member_id:member_id,password:newpassword,_token:"{{csrf_token()}}"},
                success:function () {
                    alert('修改成功！');
                    window.location.reload();
                }
            });

        }


        function pasword_confirm(member_id,password){
            var label = false;

            $.ajax({
                url:'/service/confimpassword',
                type:'post',
                data:{member_id:member_id,password:password,_token:"{{csrf_token()}}"},
                dataType:'json',
                async:false,
                success:function (res) {
                    label = res.message;
                }
            });
            return label;
        }

    </script>
@endsection