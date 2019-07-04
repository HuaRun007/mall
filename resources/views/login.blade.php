<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{$is_register==1 ? '注册': '登录'}}</title>
    <link rel="stylesheet" href="/css/auth.css">
</head>

<body>
<div class="bk_toptips"><span></span></div>
<div class="lowin">
    <div class="lowin-brand">
        <img src="/images/kodinger.jpg" alt="logo">
    </div>
    <div class="lowin-wrapper">
        @if($is_register != 1)
        <div  class="lowin-box lowin-login" >
            <div class="lowin-box-inner">
                <form>
                    <p>请登录</p>
                    <div class="lowin-group">
                        <label>账号 <a href="#" class="login-back-link">Sign in?</a></label>
                        <input type="text" name="username" class="lowin-input">
                    </div>
                    <div class="lowin-group password-group">
                        <label>密码 <a href="#" class="forgot-link"></a></label>
                        <input type="password" name="password" autocomplete="current-password" class="lowin-input">
                    </div>
                    <button type="button" class="lowin-btn login-btn" onclick="onLogin()">
                        登录
                    </button>

                    <div class="text-foot">
                        没有账号?  &nbsp;<a href="" class="register-link">去注册</a>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <div class="lowin-box lowin-register">
            <div class="lowin-box-inner">
                <form>
                    <p>请创建您的账号</p>
                    <div class="lowin-group">
                        <label>用户名</label>
                        <input type="text" name="name" autocomplete="name" class="lowin-input">
                    </div>
                    <div class="lowin-group">
                        <label for="">选择注册方式</label>
                        <input type="radio" name="register_type" value="1" class="lowin-radio" checked onclick="change_register(1)"><span class="lowin-radio-span">手机号</span>
                        <input type="radio" name="register_type"  value="2" class="lowin-radio" onclick="change_register(2)"><span class="lowin-radio-span">邮箱</span>
                    </div>
                    <div class="lowin-group" id="phone_div">
                        <label>手机号</label>
                        <input type="text" name="phone" class="lowin-input">
                    </div>
                    <div class="lowin-group" id="phone_code_div">
                        <label>验证码</label>
                        <input type="text"  name="phone_code" class="lowin-input" style="width: 60%">

                        <button type="button" class="lowin-btn" id="getPhone_code" style="width: 37%;float: right">获取验证码</button>
                    </div>
                    <div class="lowin-group" id="emial_div" style="display: none">
                        <label>邮箱</label>
                        <input type="text" name="email" class="lowin-input">
                    </div>
                    <div class="lowin-group password-group">
                        <label>密码</label>
                        <input type="password" name="password" autocomplete="current-password" class="lowin-input">
                    </div>
                    <div class="lowin-group password-group">
                        <label>确认密码</label>
                        <input type="password" name="password_again" autocomplete="current-password" class="lowin-input">
                    </div>
                    <button type="button" class="lowin-btn" onclick="onRegister()">
                        注册
                    </button>

                    <div class="text-foot">
                        已有账号? &nbsp;<a href="/login" class="login-link">登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="lowin-footer">

    </footer>
</div>

<script src="/js/auth.js"></script>
<script src="/js/jquery-3.3.1.min.js"></script>
<script>
    Auth.init({
        login_url: '#login',
        forgot_url: '#forgot'
    });
    function prompt_message(message= ''){
        $('.bk_toptips').show();
        $('.bk_toptips span').html(message);
        setTimeout(function(){$('.bk_toptips').hide();}, 2500);
    }
</script>
<script>
    function change_register(status){
        if(status==1){
            $('#phone_div').show();
            $('#phone_code_div').show();
            $('#emial_div').hide();
        }else if(status==2){
            $('#phone_div').hide();
            $('#phone_code_div').hide();
            $('#emial_div').show();
        }
    }


    var enable = true;
    $("#getPhone_code").click(function(event){
        var phone = $.trim($('input:text[name=phone]').val());
        if(phone == ''){
            prompt_message('手机号不能为空！');
            return false;
        }
        if(!isPoneAvailable(phone)){
            prompt_message('请输入正确的手机号！');
            return false;
        }
        if (enable==false){
            return;
        }
        enable = false;
        var num = 60;
        var interval = window.setInterval(function(){
            $('#getPhone_code').addClass('bk_summary');
            $('#getPhone_code').html(--num+'s 重新发送');
            if(num==0){
                $('#getPhone_code').removeClass('bk_summary');
                window.clearInterval(interval);
                $('#getPhone_code').html('&nbsp;重新发送');
                enable = true;
            }
        },1000);

        $.ajax({
            url: '/service/validate/sendSMS',
            dataType: 'json',
            cache:false,
            data: {phone: phone},
            success:function(data){
                if(data==null){
                    prompt_message('发送失败！');
                    return;
                }
                if(data.code!=0){
                    prompt_message(data.message);
                    return;
                }
                prompt_message('发送成功！');
            },
            error:function(xhr, status, message){
                console.log(xhr);
                console.log(status);
                console.log(message);
            },

        });


    });


    //验证手机号的正确性
    function isPoneAvailable(phone_number) {
        var phoneReg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;

        if (!phoneReg.test(phone_number)) {
            return false;
        } else {
            return true;
        }
    }

    //验证邮箱正确性
    function isEmailAvailable(email_number){
        var mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if(!mailReg.test(email_number)){
            return false;
        } else {
            return true;
        }
    }

    function onLogin(){
        //账号
        var username = $('input[name=username]').val();
        if(username.length == 0){
            prompt_message('账号不能为空');
            return false;
        }
        if(username.indexOf('@')== -1){ //手机号
            if(username.length!=11 || username[0] != 1){
                prompt_message('账号格式不正确');
                return false;
            }

        } else{
            if(username.indexOf('.') == -1){
                prompt_message('账号格式不对');
                return false;
            }
        }

        var password = $('input[name=password]').val();
        if(password.length == 0){
            prompt_message('密码不能为空');
            return false;
        }

        //ajax登录请求
        $.ajax({
            url: '/service/login',
            dataType: 'json',
            type:'POST',
            data:{username:username,password:password,_token:"{{csrf_token()}}",},
            success:function(data){
                console.log(data);
                if(data.code!=0){
                    prompt_message('登录失败，'+data.message);
                    return false;
                }else{
                    prompt_message('登录成功！');
                    setTimeout(function () {
                        window.location.href = data.message;
                    },1000)

                }

            },
            error:function (xhr,status, message) {
                console.log(xhr);
                console.log(status);
                console.log(message);
            }
        });
    }

    function onRegister(){
        var data = {};
        var form_data = $('form').serializeArray();
        $.each(form_data, function() {
            data[this.name] = this.value;
        });

        if($(':checked[name=register_type]').val()==1){
            if(data.phone==''){
                prompt_message('手机号不能为空！');
                return false;
            }
            if(!isPoneAvailable(data.phone)){
                prompt_message('请输入正确的手机号！');
                return false;
            }
            if(data.phone_code==''){
                prompt_message('手机验证码不能为空！');
                return false;
            }
        }

        if($(':checked[name=register_type]').val()==2){
            if(data.email==''){
                prompt_message('邮箱不能为空！');
                return false;
            }
            if(!isEmailAvailable(data.email)){
                prompt_message('请输入正确的邮箱！');
                return false;
            }

        }

        if(data.name == ''){
            prompt_message('用户名不能为空！');
            return false;
        }

        if(data.password == ''){
            prompt_message('请填写密码！');
            return false;
        }

        if(data.password_again == ''){
            prompt_message('请确认密码！');
            return false;
        }

        if(data.password_again != data.password){
            prompt_message('两次密码不一致！');
            return false;
        }

        $.ajax({
            url: '/service/register',
            dataType: 'json',
            type:'POST',
            data:{data:data,_token:"{{csrf_token()}}"},
            success:function(result){
                if(result.code!=0){
                    prompt_message('注册失败，'+result.message);
                    return false;
                }
                if(result.code==0){
                    prompt_message('注册成功！');
                    return false;
                }
            },
            error:function (xhr,status, message) {
                console.log(xhr);
                console.log(status);
                console.log(message);
            }
        });

    }



</script>
</body>
</html>