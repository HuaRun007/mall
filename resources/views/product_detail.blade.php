@extends('master')
@section('title',$product->name)
@section('content')
	<!-----------------address------------------------------->
		<div class="address">
			<div class="wrapper clearfix">
				<a href="index.html">首页</a>
				<span>/</span>
				<a href="flowerDer.html">装饰摆件</a>
				<span>/</span>
				<a href="proList.html">干花花艺</a>
				<span>/</span>
				<a href="#" class="on">【最家】非洲菊仿真花干花</a>
			</div>
		</div>
		<!-----------------------Detail------------------------------>
		<div class="detCon">
			<div class="proDet wrapper">
				<div class="proCon clearfix">
					<div class="proImg fl">
						<img class="det" src="{{$product->preview}}" />
						<div class="smallImg clearfix">
							@foreach($product_img as $item)
							<img width="85" height="85" src="{{$item->image_path}}" data-src="{{$item->image_path}}">
							@endforeach
						</div>
					</div>
					<div class="fr intro">
						<div class="title">
							<h4>{{$product->name}}</h4>
							<p>{{$product->description}}</p>
							<span>￥{{$product->price}}</span>
						</div>
						<div class="proIntro">
							<p>颜色分类</p>
							<div class="smallImg clearfix categ">
								<p class="fl on"><img src="/img/temp/prosmall01.jpg" alt="白瓷花瓶+20支快乐花" data-src="/img/temp/proBig01.jpg"></p>
								<p class="fl"><img src="/img/temp/prosmall02.jpg" alt="白瓷花瓶+20支兔尾巴草" data-src="/img/temp/proBig02.jpg"></p>
								<p class="fl"><img src="/img/temp/prosmall03.jpg" alt="20支快乐花" data-src="/img/temp/proBig03.jpg"></p>
								<p class="fl"><img src="/img/temp/prosmall04.jpg" alt="20支兔尾巴草" data-src="/img/temp/proBig04.jpg"></p>
							</div>
							<p>已卖<span>{{$product->sold_count}}</span>件</p>
							<div class="num clearfix">
								<img class="fl sub" src="/img/temp/sub.jpg">
								<span class="fl" contentEditable="true">1</span>
								<img class="fl add" src="/img/temp/add.jpg">
								<p class="please fl">请选择商品属性!</p>
							</div>
						</div>
						<div class="btns clearfix">
							<a href="javascript:;"  onclick="_buyOne()"><p class="buy fl">立即购买</p></a>
							<a href="javascript:;" onclick="_addCart()"><p class="cart fr">加入购物车</p></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="introMsg wrapper clearfix">
			<div class="msgL fl">
				<div class="msgTit clearfix">
					<a class="on">商品详情</a>
					<a>所有评价</a>
				</div>
				<div class="msgAll">
					<div class="msgImgs">
						@foreach($product_img as $item)
							<img height="800" width="800" src="{{$item->image_path}}">
						@endforeach
					</div>

					{{--评价--}}
					<div class="eva">
						@forelse($reviews as $item)
						<div class="per clearfix">
							<img class="fl" src="/img/temp/per01.jpg">
							<div class="perR fl">
								<p>{{$item->nickname}}</p>
								<p>{{$item->content}}</p>
								<p><span>{{$item->updated_at}}</span></p>
							</div>
						</div>
						@empty
							<div class="per clearfix">
								<div class="perR fl">
									<p>暂无评论</p>
								</div>
							</div>
						@endforelse

					</div>
				</div>
			</div>


			<div class="msgR fr">
				<h4>为你推荐</h4>
				<div class="seeList">
					<a href="#">
						<dl>
							<dt><img src="/img/temp/see01.jpg"></dt>
							<dd>【最家】复古文艺风玻璃花瓶</dd>
							<dd>￥193.20</dd>
						</dl>
					</a>
					<a href="#">
						<dl>
							<dt><img src="/img/temp/see02.jpg"></dt>
							<dd>【最家】复古文艺风玻璃花瓶</dd>
							<dd>￥193.20</dd>
						</dl>
					</a>
					<a href="#">
						<dl>
							<dt><img src="/img/temp/see03.jpg"></dt>
							<dd>【最家】复古文艺风玻璃花瓶</dd>
							<dd>￥193.20</dd>
						</dl>
					</a>
					<a href="#">
						<dl>
							<dt><img src="/img/temp/see04.jpg"></dt>
							<dd>【最家】复古文艺风玻璃花瓶</dd>
							<dd>￥193.20</dd>
						</dl>
					</a>
				</div>
				
			</div>


		</div>



		<div class="like">
			<h4>猜你喜欢</h4>
			<div class="bottom">
				<div class="hd">
					<span class="prev"><img src="/img/temp/prev.png"></span>
					<span class="next"><img src="/img/temp/next.png"></span>
				</div>
				<div class="imgCon bd">
					<div class="likeList clearfix">
						<div>
						@foreach($likeList as $item)
								<a href="/product/detail/{{$item->id}}">
									<dl>
										<dt><img src="{{$item->preview}}"></dt>
										<dd>【最家】{{$item->name}}</dd>
										<dd>￥{{$item->price}}</dd>
									</dl>
								</a>
						@endforeach

						</div>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('my-js')
		<script type="text/javascript">
            jQuery(".bottom").slide({titCell:".hd ul",mainCell:".bd .likeList",autoPage:true,autoPlay:false,effect:"leftLoop",autoPlay:true,vis:1});
		</script>
		<script>
            function _addCart(){
                var num = parseInt($(".num span").text());
                $.ajax({
                    url:"{{url('/service/cart/add',['product'=>$product])}}",
                    type: 'GET',
					data:{num:num},
                    dataType: 'JSON',
                    success:function(data){
						console.log(data);
                    },
                    error:function(xhr,status,message){
                        console.log(xhr);
                        console.log(status);
                        console.log(message);
                    }
                });
            }

            function _buyOne(){
                var num = parseInt($(".num span").text());
                window.location.href = '/buyOne/'+"{{$product->id}}"+'/'+num;
            }
		</script>
@endsection