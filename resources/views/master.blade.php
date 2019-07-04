<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title','')</title>
    <link rel="stylesheet" type="text/css" href="/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/css/proList.css"/>
    <style>
        #search_ul {
            width: 160px;
            height: 30px;
            margin: 0;
            position: fixed;
            z-index: 100;
        }
        #search_ul li{
            width: 160px;
            height: 30px;
            background-color: white;
            line-height: 30px;
        }
        #search_ul a{
            font-size: 12px;
            font-family: "微软雅黑", "arial";
            color: #262626;
        }
    </style>
</head>
<body>
<!------------------------------head------------------------------>
<div class="head">
    <div class="wrapper clearfix">
        <div class="clearfix" id="top">
            <h1 class="fl"><a href="/"><img src="/img/logo.png"/></a></h1>
            <div class="fr clearfix" id="top1">
                @if($member)
                    <p class="fl">
                        <a href="/myinfo"  style="color: #FD482C">欢迎您：{{$member->nickname}}</a>
                        <a href="/service/logout" >退出</a>
                    </p>
                @else
                    <p class="fl">
                        <a href="/login" id="login">登录</a>
                        <a href="/register" id="reg">注册</a>
                    </p>
                @endif
                <form action="#" method="get" class="fl">
                    <input type="text" id="index_search_input" placeholder="热门搜索：干花花瓶" />
                    <input type="button" id="index_search_button" />
                    <ul id="search_ul">

                    </ul>
                </form>
                <div class="btn fl clearfix">
                    <a href="/cart" target="_blank"><img src="/img/gwc.png"/></a>
                    <p><a href="#"><img src="/img/smewm.png"/></a></p>
                </div>
            </div>
        </div>
        <ul class="clearfix" id="bott">
            <li><a href="/">首页</a></li>
            <li>
                <a href="#">商品分类</a>
                <div class="sList">
                    <div class="wrapper  clearfix">
                        @forelse($index_category as $item)
                            <a href="/category/{{$item->id}}" target="_blank">
                                <dl>
                                    <dt><img src="{{$item->preview}}"/></dt>
                                    <dd>{{$item->name}}</dd>
                                </dl>
                            </a>
                        @empty

                        @endforelse
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
@yield('content')



<!--返回顶部-->
<div class="gotop">
    <a href="/cart" target="_blank">
        <dl class="goCart">
            <dt><img src="/img/gt1.png"/></dt>
            <dd>去购<br />物车</dd>
            <span>0</span>
        </dl>
    </a>
    <a href="#" class="dh">
        <dl>
            <dt><img src="/img/gt2.png"/></dt>
            <dd>联系<br />客服</dd>
        </dl>
    </a>
    <a href="/myinfo">
        <dl>
            <dt><img src="/img/gt3.png"/></dt>
            <dd>个人<br />中心</dd>
        </dl>
    </a>
    <a href="#" class="toptop" style="display: none;">
        <dl>
            <dt><img src="/img/gt4.png"/></dt>
            <dd>返回<br />顶部</dd>
        </dl>
    </a>
    <p>400-800-8200</p>
</div>
<div class="msk"></div>
<!--footer-->
<div class="footer">
    <div class="top">
        <div class="wrapper">
            <div class="clearfix">
                <a href="#2" class="fl"><img src="/img/foot1.png"/></a>
                <span class="fl">7天无理由退货</span>
            </div>
            <div class="clearfix">
                <a href="#2" class="fl"><img src="/img/foot2.png"/></a>
                <span class="fl">15天免费换货</span>
            </div>
            <div class="clearfix">
                <a href="#2" class="fl"><img src="/img/foot3.png"/></a>
                <span class="fl">满599包邮</span>
            </div>
            <div class="clearfix">
                <a href="#2" class="fl"><img src="/img/foot4.png"/></a>
                <span class="fl">手机特色服务</span>
            </div>
        </div>
    </div>
    <p class="dibu">最家家居&copy;2013-2017公司版权所有 京ICP备080100-44备0000111000号<br />
        违法和不良信息举报电话：188-0130-1238，本网站所列数据，除特殊说明，所有数据均出自我司实验室测试</p>
</div>
</body>
<script src="/js/jquery-1.12.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/public.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/nav.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/pro.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/cart.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/jquery.flexslider-min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $('#index_search_button').click(function(){
        var name = $('#index_search_input').val();
        $.ajax({
            type:'post',
            url:'/service/search/',
            data:{product:name,_token:"{{csrf_token()}}"},
            dataType:'json',
            success:function(result){
                if(result.code==0){
                    $('#search_ul').html('');
                    $(result.message).each(function(k,v){
                        $('#search_ul').append('<li><a href="/product/detail/'+v.id+'">'+v.name+'</a></li>')
                    })
                }else{
                    $('#search_ul').html('');
                    $('#search_ul').append('<li><a href="javascript:;">'+result.message+'</a></li>')
                }

            }
        })
    });

    $(function(){
        $.ajax({
            url: '/service/getCartnum',
            type: 'post',
            data: {_token: "{{csrf_token()}}"},
            dataType: 'json',
            success:function(res){
                if(res.code==0){
                    $('.goCart span').text(res.num);
                }else{

                }
            }
        });
    })
</script>
@yield('my-js')
</html>
