@extends('info_base')

@section('title','评价商品')

@section('content')
    <!------------------------------Bott------------------------------>
    <div class="Bott">
        <div class="wrapper clearfix">
            <div class="you fl">
                <div class="my clearfix">
                    <h2 class="fl">商品评价</h2>
                </div>
                <div class="dlist">
                    <ul class="clearfix" id="pro">
                        <li class="on"><a href="#2">待评价商品</a></li>
                        <li><a href="#2">已评价商品</a></li>
                        <li><a href="#2">评价失效商品</a></li>
                    </ul>
                </div>
                <div class="sx clearfix">
                    <div class="clearfix">
                        @foreach($order_detail as $item)
                        <dl class="fl">
                            <dt><a href="#"><img width="162" height="200" src="{{$item->preview}}"/></a></dt>
                            <dd><a href="#">{{$item->product_name}}</a></dd>
                            <dd>¥{{$item->price}}</dd>
                            {{--<dd>16000人评价</dd>--}}
                            <dd><a href="#2" data-id="{{$item->id}}">评价</a></dd>
                        </dl>
                        @endforeach
                    </div>
                    {{--已评价--}}
                    <div class="clearfix">
                        <dl class="fl">
                            <dt><a href="#"><img src="/img/nav3.jpg"/></a></dt>
                            <dd><a href="#">家用创意壁挂  釉下彩复古</a></dd>
                            <dd>¥199.00</dd>
                            <dd>16000人评价</dd>
                            <dd><a href="#2">查看评价</a></dd>
                        </dl>
                    </div>
                    <div class="clearfix" >
                        <dl class="fl">
                            <dt><a href="#"><img src="/img/nav3.jpg"/></a></dt>
                            <dd><a href="#">家用创意壁挂  釉下彩复古</a></dd>
                            <dd>¥199.00</dd>
                            <dd>16000人评价</dd>
                            <dd><a href="#2">暂不能评价</a></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--遮罩-->
    <div class="mask"></div>
    <!--评价弹框-->
    <div class="pj">
        <div class="clearfix"><a href="#" class="fr gb"><img src="/img/icon4.png"/></a></div>
        <h3>商品评分</h3>
        <form action="#" method="get">
            <div class="clearfix">
                <p class="fl">请打分：</p>
                <p class="fl" id="xin">
                    <a href="#2"><img src="/img/xin.png"/></a>
                    <a href="#2"><img src="/img/xin.png"/></a>
                    <a href="#2"><img src="/img/xin.png"/></a>
                    <a href="#2"><img src="/img/xin.png"/></a>
                    <a href="#2"><img src="/img/xin.png"/></a>
                </p>
            </div>
            <input id="detail_id"  type="hidden" value="">
            <input id="rating"  type="hidden" value="">
            <textarea id="content" rows="" cols="" placeholder="请输入评价" ></textarea>
            <div class="bc">
                <input type="button" value="保存"  onclick="_toReview()" />
                <input type="button" value="取消" />
            </div>
        </form>
    </div>

    <!--查看评价-->
    <div class="chak">
        <div class="clearfix"><a href="#" class="fr gb"><img src="/img/icon4.png"/></a></div>
        <h3>商品评分</h3>
        <form action="#" method="get">
            <div class="clearfix">
                <p class="fl">请打分：</p>
                <p class="fl" id="xin">
                    <a href="#2"><img src="/img/hxin.png"/></a>
                    <a href="#2"><img src="/img/hxin.png"/></a>
                    <a href="#2"><img src="/img/hxin.png"/></a>
                    <a href="#2"><img src="/img/hxin.png"/></a>
                    <a href="#2"><img src="/img/hxin.png"/></a>
                </p>
            </div>
            <textarea name="" rows="" cols="" placeholder="请输入评价" >挺好的挺好的挺好的~五分好评</textarea>
            <div class="bc">
                <input type="button" value="保存"  />
                <input type="button" value="取消" />
            </div>
        </form>
    </div>


@endsection


@section('my-js')
    <script>
        function _toReview(){
            var detail_id = $('#detail_id').val();
            var rating = $('#rating').val();
            var content = $('#content').val();
            if(rating==''){
                alert('请打分');
                return;
            }

            if(content==''){
                alert('请填写评价');
                return;
            }

            $.ajax({
               url:'/service/review',
               type:'post',
               data:{detail_id:detail_id,rating:rating,content:content,_token:"{{csrf_token()}}"} ,
               dataType:'json',
               success:function (res) {
                    if(res.code==0){
                        alert('评论成功！');
                        window.location.reload();
                    }else {
                        alert('评论失败！');
                        window.location.reload();
                    }
               }
            });
        }
    </script>
@endsection