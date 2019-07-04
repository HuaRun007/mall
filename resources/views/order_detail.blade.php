@extends('info_base')

@section('title', '订单')

@section('content')
    <link rel="stylesheet" type="text/css" href="/css/myorder.css" />
    <!------------------------------Bott------------------------------>
            <div class="you fl">
                <div class="my clearfix">
                    <h2>订单详情<a href="#">请谨防钓鱼链接或诈骗电话，了解更多&gt;</a></h2>
                    <h3>订单号：<span>{{$order->no}}</span></h3>
                </div>
                <div class="orderList">
                    <div class="orderList1">
                        <h3>已收货</h3>
                        @foreach($order->order_detail as $item)
                        <div class="clearfix" style="margin-top: 20px;">
                            <a href="/product/detail/{{$item->product_id}}" target="_blank" class="fl"><img width="65" height="65" src="{{$item->preview}}"/></a>
                            <p class="fl"><a href="/product/detail/{{$item->product_id}}" target="_blank">{{$item->name}}</a><a href="#">¥{{$item->price}}×{{$item->number}}</a></p>
                        </div>
                        @endforeach
                    </div>

                    <div class="orderList1">
                        <h3>收货信息</h3>
                        <p>姓 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<span>{{$order->member_name}}</span></p>
                        <p>联系电话：<span>157*****121</span></p>
                        <p>收货地址：<span>河北 唐山市 路北区 高新软件园</span></p>
                    </div>
                    <div class="orderList1">
                        <h3>支付方式及送货时间</h3>
                        <p>支付方式：<span>在线支付</span></p>
                        <p>送货时间：<span>不限送货时间</span></p>
                    </div>
                    <div class="orderList1 hei">
                        <h3><strong>商品总价：</strong><span>¥{{$order->total_amount}}</span></h3>
                        <p><strong>运费：</strong><span>¥0</span></p>
                        <p><strong>订单金额：</strong><span>¥{{$order->total_amount}}</span></p>
                        <p><strong>实付金额：</strong><span>¥{{$order->total_amount}}</span></p>
                    </div>

                </div>
            </div>

@endsection

@section('my-js')
    <script src="/js/user.js" type="text/javascript" charset="utf-8"></script>
@endsection