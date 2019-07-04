@extends('master')

@section('title', '购物车')

@section('content')
    <style></style>
    <div class="cart">
        <!-----------------logo------------------->
        <!--<div class="logo">
            <h1 class="wrapper clearfix">
                <a href="index.html"><img class="fl" src="img/temp/logo.png"></a>
                <img class="top" src="img/temp/cartTop01.png">
            </h1>
        </div>-->
        <!-----------------site------------------->
        <div class="site">
            <p class=" wrapper clearfix">
                <span class="fl">购物车</span>
                <img class="top" src="/img/temp/cartTop01.png">
                <a href="index.html" class="fr">继续购物&gt;</a>
            </p>
        </div>
        <!-----------------table------------------->
        <div class="table wrapper">
            <div class="tr">
                <div>商品</div>
                <div>单价</div>
                <div>数量</div>
                <div>小计</div>
                <div>操作</div>
            </div>

            @forelse($carts as $item)
            <div class="th" style="text-align: center" data-id="{{$item->id}}">
                <div class="pro clearfix">
                    <label class="fl">
                        <input type="checkbox"/>
                        <span></span>
                    </label>
                    <a class="fl" href="/product/detail/{{$item->id}}" target="_blank">
                        <dl class="clearfix">
                            <dt class="fl"><img width="120" height="120" src="{{$item->preview}}"></dt>
                            <dd class="fl">
                                <p>创意现代简约干花花瓶摆件</p>
                                <p>颜色分类:</p>
                                <p>白色瓷瓶+白色串枚</p>
                            </dd>
                        </dl>
                    </a>
                </div>
                <div class="price">￥{{$item->price}}</div>
                <div class="number">
                    <p class="num clearfix">
                        <img class="fl sub" src="/img/temp/sub.jpg">
                        <span class="fl num1" >{{$item->num}}</span>
                        <img class="fl add" src="/img/temp/add.jpg">
                    </p>
                </div>
                <div class="price sAll">￥<span>{{$item->sum_price}}</span></div>
                <div class="price"><a class="del" href="#2">删除</a></div>
                <input type="hidden" name="product_data" data-id="{{$item->id}}" data-preview="{{$item->preview}}" data-price="{{$item->price}}"  data-name="{{$item->name}}"    />
            </div>
            @empty

            <div class="goOn" style="display: block">空空如也~<a href="/">去逛逛</a></div>
            @endforelse
            <div class="goOn">空空如也~<a href="/">去逛逛</a></div>

            <div class="tr clearfix">
                <label class="fl">
                    <input class="checkAll" type="checkbox"/>
                    <span></span>
                </label>
                <p class="fl">
                    <a href="#">全选</a>
                    <a href="#" class="del">删除</a>
                </p>
                <p class="fr">
                    <span>共<small id="sl">0</small>件商品</span>
                    <span>合计:&nbsp;<small id="all">￥0.00</small></span>
                    <a href="javascript:;" class="count">结算</a>
                </p>
            </div>
        </div>
    </div>
    <div class="mask"></div>
    <div class="tipDel">
        <p>确定要删除该商品吗？</p>
        <p class="clearfix">
            <a class="fl cer" href="#">确定</a>
            <a class="fr cancel" href="#">取消</a>
        </p>
    </div>
@endsection

@section('my-js')
    <script>
        $('.count').click(function(){
            var member = "{{$member}}";

            if(member == ''){
                alert('请登录！');
                window.location.href = '/login';
                return false;
            }

            var product_num = parseInt($('#sl').text());
            if(product_num == 0){
                return false;
            }else{
                var products = {};
                var data = $(".th input[type='checkbox']:checked").parents('.th').children(':input[name=product_data]');


                // console.log(data);return

                $(data).each(function(k,v){
                    var arr = {};
                    arr['id'] = $(v).data('id');
                    arr['name'] = $(v).data('name');
                    arr['num'] = parseInt($($('.num1')[k]).html());
                    arr['price'] = $(v).data('price');
                    arr['preview'] = $(v).data('preview');
                    arr['sumprice'] = $($('.sAll span')[k]).html();
                    products[k] = arr ;
                });

                $.ajax({
                    url: '/buy',
                    type:'post',
                    data:{products:products,_token:"{{csrf_token()}}"},
                    dataType:'json',
                    success:function (result) {
                        if(result.code==0){
                           window.location.href = '/tobuy';
                        }

                    }
                });
            }
        });
        //
        // $(".num .sub").click(function(){
        //     var num = parseInt($(this).siblings("span").text());
        //     if(num<=1){
        //         $(this).attr("disabled","disabled");
        //     }else{
        //         num--;
        //         $(this).siblings("span").text(num);
        //         //获取除了货币符号以外的数字
        //         var price = $(this).parents(".number").prev().text().substring(1);
        //         //单价和数量相乘并保留两位小数
        //         $(this).parents(".th").find(".sAll").text('￥'+(num*price).toFixed(2));
        //         jisuan();
        //         zg();
        //     }
        // });
        // $(".num .add").click(function(){
        //     var num = parseInt($(this).siblings("span").text());
        //
        //     num++;
        //     $(this).siblings("span").text(num);
        //     var price = $(this).parents(".number").prev().text().substring(1);
        //     $(this).parents(".th").find(".sAll").text('￥'+(num*price).toFixed(2));
        //     jisuan();
        //     zg();
        //
        // });
    </script>
@endsection