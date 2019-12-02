@extends('info_base')

@section('title', '我的订单')

@section('content')
    <link rel="stylesheet" type="text/css" href="/css/myorder.css" />
    <link rel="stylesheet" type="text/css" href="/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/css/proList.css"/>
    <!------------------------------Bott------------------------------>
            <div class="you fl">
                <div class="my clearfix">
                    <h2 class="fl">我的订单</h2>
                    <a href="#" class="fl">请谨防钓鱼链接或诈骗电话，了解更多&gt;</a>
                </div>
                <div class="dlist clearfix">
                    <ul class="fl clearfix" id="wa">
                        <li class="on"><a href="#2">全部有效订单</a></li>
                        <li><a href="#2">待支付</a></li>
                        <li><a href="#2l">待收货</a></li>
                        <li><a href="#2">已关闭</a></li>
                    </ul>
                </div>
                @foreach($orders as $item)
                        <div class="dkuang deng">
                            <p class="one">
                                @if($item->paystatus == 2)
                                    未支付
                                @elseif($item->paystatus == 1 && $item->status ==1 )
                                已支付
                                @elseif($item->paystatus == 1 && $item->status ==2 )
                                待发货
                                @elseif($item->paystatus == 1 && $item->status ==3 )
                                已发货
                                @else
                                已完成
                                    @endif

                            </p>
                            <div class="word clearfix">
                                <ul class="fl clearfix">
                                    <li>{{$item->created_at}}</li>
                                    <li>{{$item->member_name}}</li>
                                    <li>订单号:{{$item->no}}</li>
                                    <li>{{$item->payment_method ==1 ? '支付宝支付' : '微信支付'}}</li>
                                </ul>
                                <p class="fr">订单金额：<span>{{$item->total_amount}}</span>元</p>
                            </div>
                            <div class="shohou clearfix">
                                <p class="fl">
                                @forelse($item->order_detail as $item2)
                                    <a href="/product/detail/{{$item2->product_id}}" target="_blank">{{$item2->product_name}}</a><a href="#">¥{{$item2->price}}×{{$item2->number}}</a>

                                    @empty

                                    @endforelse
                                </p>
                                <p class="fr">
                                    @if($item->paystatus == 2)
                                        <a href="/pay/{{$item->id}}" target="_blank">立即支付</a>
                                    @elseif($item->paystatus == 1 && $item->status == 1)
                                        <a href="javascript:;" target="_blank">待后台确认</a>
                                    @elseif($item->paystatus == 1 && $item->status == 2)
                                        <a href="javascript:;" >待发货</a>
                                    @elseif($item->paystatus == 1 && $item->status == 3)
                                        <a href="javascript:;" onclick="_Receipt({{$item->id}})" target="_blank">确认收货</a>
                                    @elseif($item->paystatus == 1 && $item->status == 4)
                                        <a href="/review/{{$item->id}}" style="border:1px solid #B0B0B0;color: #666666;background: white;"  onMouseOver="this.style.background='#666';this.style.color='white';"
                                           onMouseOut="this.style.background='white';this.style.color='#666666';" target="_blank">待评价</a>
                                    @endif
                                    <a href="/order/detail/{{$item->id}}" >订单详情</a>
                                </p>
                            </div>
                        </div>
                @endforeach
                <div class="fenye clearfix">
                    <a href="#"><img src="/img/zuo.jpg"/></a>
                    <a href="#">1</a>
                    <a href="#"><img src="/img/you.jpg"/></a>
                </div>
            </div>
    <div class="mask"></div>
    <div class="tipDel">
        <p>确定收到该商品吗？</p>
        <p class="clearfix">
            <a class="fl cer" href="#">确定</a>
            <a class="fr cancel" href="#">取消</a>
        </p>
    </div>
@endsection


@section('my-js')
    <script src="/js/user.js" type="text/javascript" charset="utf-8"></script>
    <script>
        function _Receipt(id) {
            $(".mask").show();
            $(".tipDel").show();

            $('.cer').click(function(){
                $.ajax({
                    url:'/receipt',
                    type:'post',
                    data:{id:id,_token:"{{csrf_token()}}"},
                    dataType:'json',
                    success:function (res) {
                            $(".mask").hide();
                            $(".tipDel").hide();
                            window.location.reload();

                    }
                })
            });

        }
        $('.cancel').click(function(){
            $(".mask").hide();
            $(".tipDel").hide();
        })
    </script>
@endsection