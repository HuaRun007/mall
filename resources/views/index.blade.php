@extends('master')

@section('title','首页')

@section('content')
	<head lang="en">
		<meta charset="utf-8" />
		<title>最家</title>
		<link rel="stylesheet" type="text/css" href="/css/public.css"/>
		<link rel="stylesheet" type="text/css" href="/css/index.css" />
	</head>
		<!-------------------------banner 轮播图--------------------------->
		<div class="block_home_slider">
			<div id="home_slider" class="flexslider">
				<ul class="slides">
					@forelse($site_images as $image)
					<li>
						<div class="slide">
							<img src="{{$image->image_path}}"/>
						</div>
					</li>
					@empty

					@endforelse
				</ul>
			</div>
		</div>

		<!------------------------------thImg------------------------------>
		<div class="thImg">
			<div class="clearfix">
				<a href="vase_proList.html"><img src="/img/i1.jpg"/></a>
				<a href="proList.html"><img src="/img/i2.jpg"/></a>
				<a href="#2"><img src="/img/i3.jpg"/></a>
			</div>
		</div>

		<!------------------------------news------------------------------>
		{{--<div class="news">--}}
			{{--<div class="wrapper">--}}
				{{--<h2><img src="img/ih1.jpg"/></h2>--}}
				{{--<div class="top clearfix">--}}
					{{--<a href="proDetail.html"><img width="545" height="310" src="/img/n1.jpg"/><p></p></a>--}}
					{{--<a href="proDetail.html"><img width="270" height="310" src="/img/n2.jpg"/><p></p></a>--}}
					{{--<a href="proDetail.html"><img width="270" height="310" src="/img/n3.jpg"/><p></p></a>--}}
				{{--</div>--}}
				{{--<div class="bott clearfix">--}}
					{{--<a href="proDetail.html"><img width="270" height="310" src="/img/n4.jpg"/><p></p></a>--}}
					{{--<a href="proDetail.html"><img width="270" height="310" src="/img/n5.jpg"/><p></p></a>--}}
					{{--<a href="proDetail.html"><img width="545" height="310" src="/img/n6.jpg"/><p></p></a>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}

		<!------------------------------ad------------------------------>
		<a href="#" class="ad"><img src="/img/ib1.jpg"/></a>

		<!------------------------------people------------------------------>
	@foreach($products as $item)
		<div class="people">
			<div class="wrapper">
				<h2 style="color: #9F9F9F;width: 80px;height:50px;text-align: center">{{$item->name}}</h2>
				<div class="pList clearfix tran">
				@foreach($item->product as $item2)
						<a href="/product/detail/{{$item2->id}}" target="_blank">
							<dl>
								<dt>
									<span class="abl"></span>
									<img  src="{{$item2->preview}}"/>
									<span class="abr"></span>
								</dt>
								<dd>{{$item2->name}}</dd>
								<dd><span>￥{{$item2->price}}</span></dd>
							</dl>
						</a>
					@endforeach
				</div>

			</div>
		@endforeach
@endsection
@section('my-js')
	<script type="text/javascript">
        $(function() {
            $('#home_slider').flexslider({
                animation: 'slide',
                controlNav: true,
                directionNav: true,
                animationLoop: true,
                slideshow: true,
                slideshowSpeed:3500,
                useCSS: false
            });

        });
	</script>
@endsection