@extends('master')
@section('title','商品分类')
@section('content')
    <!-----------------address------------------------------->
    <div class="address">
        <div class="wrapper clearfix">
            <a href="/">首页</a>
            <span>/</span>
            <a href="/category/{{$category->id}}" class="on">{{$category->name}}</a>
        </div>
    </div>
    <!-----------------paintCon------------------------------->
    <div class="paintCon">
        @forelse($products as $item)
        <section class="wrapper">
            <h3>{{$item->name}}</h3>
            <div class="paintList">
            @foreach($item->product as $item2)
                <a href="/product/detail/{{$item2->id}}" target="_blank">
                    <dl>
                        <dt><img src="{{$item2->preview}}"></dt>
                        <dd>{{$item2->name}} </dd>
                        <dd>￥{{$item2->price}}</dd>
                    </dl>
                </a>
            @endforeach
            </div>
        </section>
        @empty
            <h1>没有产品</h1>
        @endforelse
    </div>
@endsection

@section('my-js')

@endsection