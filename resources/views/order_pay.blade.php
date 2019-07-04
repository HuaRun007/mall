@extends('master')

@section('title', '订单')

@section('content')
    <div class="order cart">
        <!-----------------site------------------->
        <div class="site">
            <p class="wrapper clearfix">
                <span class="fl">订单确认</span>
                <img class="top" src="/img/temp/cartTop02.png">
            </p>
        </div>
        <!-----------------orderCon------------------->
        <div class="orderCon wrapper clearfix">
            <div class="orderL fl">
                <!--------h3---------------->
                <h3>收件信息<a href="#" class="fr">新增地址</a></h3>
                <!--------addres---------------->
                <div class="addres clearfix">
                    <div class="addre fl on">
                        <div class="tit clearfix">
                            <p class="fl">张三1
                                <span class="default">[默认地址]</span>
                            </p>
                            <p class="fr">
                                <a href="#">删除</a>
                                <span>|</span>
                                <a href="#" class="edit">编辑</a>
                            </p>
                        </div>
                        <div class="addCon">
                            <p>河北省&nbsp;唐山市&nbsp;路北区&nbsp;大学生公寓村</p>
                            <p>15732570937</p>
                        </div>
                    </div>
                    <div class="addre fl">
                        <div class="tit clearfix">
                            <p class="fl">张三2
                            </p>
                            <p class="fr">
                                <a href="#" class="setDefault">设为默认</a>
                                <span>|</span>
                                <a href="#">删除</a>
                                <span>|</span>
                                <a href="#" class="edit">编辑</a>
                            </p>
                        </div>
                        <div class="addCon">
                            <p>河北省&nbsp;唐山市&nbsp;路北区&nbsp;大学生公寓村</p>
                            <p>15732570937</p>
                        </div>
                    </div>
                    <div class="addre fl">
                        <div class="tit clearfix">
                            <p class="fl">张三3
                            </p>
                            <p class="fr">
                                <a href="#" class="setDefault">设为默认</a>
                                <span>|</span>
                                <a href="#">删除</a>
                                <span>|</span>
                                <a href="#" class="edit">编辑</a>
                            </p>
                        </div>
                        <div class="addCon">
                            <p>河北省&nbsp;唐山市&nbsp;路北区&nbsp;大学生公寓村</p>
                            <p>15732570937</p>
                        </div>
                    </div>
                </div>
                <h3>支付方式</h3>
                <!--------way---------------->
                <div class="way clearfix">
                    <img class="on" src="/img/temp/way01.jpg">
                    {{--<img src="/img/temp/way02.jpg">--}}
                </div>
            </div>
            <div class="orderR fr">
                    <!--------ul---------------->
                    @if($is_buyone == 1)
                    <div class="msg">
                        <h3>订单内容<a href="cart.html" class="fr">返回购物车</a></h3>
                        <ul class="clearfix">
                            <li class="fl">
                                <img width="87" height="87" src="{{$order_product->preview}}">
                            </li>
                            <li class="fl">
                                <p>{{$order_product->name}}</p>
                                <p>颜色分类：烟灰色玻璃瓶</p>
                                <p>数量：{{$order_product->num}}</p>
                            </li>
                            <li class="fr">￥{{$order_product->price}}</li>
                        </ul>
                        <!--------tips---------------->
                        <div class="tips">
                            <p><span class="fl">商品金额：</span><span class="fr">￥{{$order_product->sumprice}}</span></p>
                            <p><span class="fl">运费：</span><span class="fr">免运费</span></p>
                        </div>
                </div>
                    @else
                    <div class="msg">
                        <h3>订单内容<a href="cart.html" class="fr">返回购物车</a></h3>
                        @foreach($order_product as $item)
                            <ul class="clearfix">
                                <li class="fl">
                                    <img width="87" height="87" src="{{$item['preview']}}">
                                </li>
                                <li class="fl">
                                    <p>{{$item['name']}}</p>
                                    <p>颜色分类：烟灰色玻璃瓶</p>
                                    <p>数量：{{$item['num']}}</p>
                                </li>
                                <li class="fr">￥{{$item['price']}}</li>
                            </ul>
                            <!--------tips---------------->
                            <div class="tips">
                                <p><span class="fl">商品金额：</span><span class="fr">￥{{$item['sumprice']}}</span></p>
                                <p><span class="fl">运费：</span><span class="fr">免运费</span></p>
                            </div>
                        @endforeach
                    </div>
                        <!--------tips count---------------->
                            <div class="count tips">
                                <p><span class="fl">合计：</span><span class="fr">￥{{$sum_price}}</span></p>
                            </div>
                    @endif


                <!--<input type="button" name="" value="去支付"> -->
                <a href="javascript:;" class="pay">去支付</a>
            </div>
        </div>
    </div>
    <!--编辑弹框-->
    <!--遮罩-->

@endsection

@section('my-js')
    <script>
        $('.pay').click(function(){
            window.open('/pay');
        });
    </script>
@endsection