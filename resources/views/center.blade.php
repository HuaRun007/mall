@extends('info_base')
@section('title',$member->nickname.'的个人空间')
@section('content')
    <link rel="stylesheet" type="text/css" href="/css/mygxin.css" />
    <link rel="stylesheet" type="text/css" href="/css/myorder.css" />
    <script src="/js/user.js" type="text/javascript" charset="utf-8"></script>
<!------------------------------Bott------------------------------>
<div class="Bott">
    <div class="wrapper clearfix">
        <div class="you fl">
            <div class="tx clearfix">
                <div class="fl clearfix">
                    <a href="#" class="fl"><img src="img/tx.png"/></a>
                    <p class="fl"><span>{{$member->nickname}}</span><a href="mygrxx.html">修改个人信息></a></p>
                </div>
                {{--<div class="fr">绑定邮箱：12****4@**.com</div>--}}
            </div>
            <div class="bott">
                <div class="clearfix">
                    <a href="#" class="fl"><img src="img/gxin1.jpg"/></a>
                    <p class="fl"><span>待支付的订单：<strong>{{$payorders}}</strong></span>
                        <a href="/orders">查看待支付订单></a>
                    </p>
                </div>
                <div class="clearfix">
                    <a href="#" class="fl"><img src="img/gxin2.jpg"/></a>
                    <p class="fl"><span>待收货的订单：<strong>{{$waitorders}}</strong></span>
                        <a href="/orders">查看待收货订单></a>
                    </p>
                </div>
                <div class="clearfix">
                    <a href="/review/0" class="fl"><img src="img/gxin3.jpg"/></a>
                    <p class="fl"><span>待评价的订单：<strong>{{$waitreviews}}</strong></span>
                        <a href="/review/0">查看待评价订单></a>
                    </p>
                </div>
                {{--<div class="clearfix">--}}
                    {{--<a href="#" class="fl"><img src="img/gxin4.jpg"/></a>--}}
                    {{--<p class="fl"><span>喜欢的商品：<strong>0</strong></span>--}}
                        {{--<a href="#">查看喜欢的商品></a>--}}
                    {{--</p>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
@endsection
