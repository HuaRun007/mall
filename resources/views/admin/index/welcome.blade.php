<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="/adminstatic/css/font.css">
    <link rel="stylesheet" href="/adminstatic/css/xadmin.css">
    <script type="text/javascript" src="/adminstatic/js/jquery.min.js"></script>
</head>
<body>
<div class="x-body">
    <blockquote class="layui-elem-quote">欢迎管理员：
        <span class="x-red">{{$user['username']}}</span>！当前时间:<span id="admin_clock">2018-04-25 20:50:53</span></blockquote>
    <fieldset class="layui-elem-field">
        <legend>数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>会员数</h3>
                                            <p>
                                                <cite>{{$data['member_num']}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>订单数</h3>
                                            <p>
                                                <cite>{{$data['order_num']}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>商品数</h3>
                                            <p>
                                                <cite>{{$data['product_num']}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>交易额</h3>
                                            <p>
                                                <cite>{{$data['total_amount']}}</cite></p>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>系统版本</th>
                    <td>1.0</td></tr>
                <tr>
                    <th>服务器地址</th>
                    <td>{{$_SERVER['HTTP_HOST']}}</td></tr>
                <tr>
                    <th>操作系统</th>
                    <td>WINNT</td></tr>
                <tr>
                    <th>运行环境</th>
                    <td>Nginx</td></tr>
                <tr>
                    <th>PHP版本</th>
                    <td>{{phpversion()}}</td></tr>
                <tr>
                    <th>PHP运行方式</th>
                    <td>cgi-fcgi</td></tr>
                <tr>
                    <th>MYSQL版本</th>
                    <td>5.5.53</td></tr>
                <tr>
                    <th>Laravel</th>
                    <td>5.1</td></tr>
                <tr>
                    <th>执行时间限制</th>
                    <td>30s</td></tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    {{--<fieldset class="layui-elem-field">--}}
        {{--<legend>开发团队</legend>--}}
        {{--<div class="layui-field-box">--}}
            {{--<table class="layui-table">--}}
                {{--<tbody>--}}

                {{--</tbody>--}}
            {{--</table>--}}
        {{--</div>--}}
    {{--</fieldset>--}}
</div>
<script>
    // var _hmt = _hmt || [];
    // (function() {
    //     var hm = document.createElement("script");
    //     hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
    //     var s = document.getElementsByTagName("script")[0];
    //     s.parentNode.insertBefore(hm, s);
    // })();
    $(function () {
        setInterval(function(){
            var dateObject = new Date();
            var year = dateObject.getFullYear();
            var month = dateObject.getMonth()+1;
            var day = dateObject.getDate();
            var hours = dateObject.getHours();
            var minutes = dateObject.getMinutes();
            var seconds = dateObject.getSeconds();
            if(hours<10){
                hours = '0'+hours;
            }
            if(minutes<10){
                minutes = '0'+minutes;
            }
            if(seconds<10){
                seconds = '0'+seconds;
            }

            $('#admin_clock').html(year+"-"+month+"-"+day+"  "+hours+":"+minutes+":"+seconds);

        },1000)


    })

</script>
</body>
</html>