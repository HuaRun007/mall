@extends('info_base')

@yield('title','修改个人信息')

@section('content')
    <link rel="stylesheet" type="text/css" href="/css/mygrxx.css" />
    <link rel="stylesheet" type="text/css" href="/css/myorder.css" />

    <!------------------------------Bott------------------------------>
    <div class="Bott">
        <div class="wrapper clearfix">
            <div class="you fl">
                <h2>个人信息</h2>
                <div class="gxin">
                    <div class="tx"><a href="#"><img src="img/tx.png"/><p id="avatar">修改头像</p></a></div>
                    <div class="xx">
                        <h3 class="clearfix"><strong class="fl">基础资料</strong><a href="#" class="fr" id="edit1">编辑</a></h3>
                        <div>昵称：{{$member->nickname}}</div>
                        <div>注册时间：{{$member->created_at}}</div>
                        <div>积分：{{$member->integral}}</div>
                        <h3>高级设置</h3>
                        <!--<div><span class="fl">银行卡</span><a href="#" class="fr">管理</a></div>-->
                        <div><span class="fl">账号地区：中国</span><a href="#" class="fr" id="edit2">修改</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--遮罩-->
    <div class="mask"></div>
    <!--编辑弹框-->
    <div class="bj">
        <div class="clearfix"><a href="#" class="fr gb"><img src="img/icon4.png"/></a></div>
        <h3>编辑基础资料</h3>
        <form action="#" method="get">
            <p><label>昵称：</label><input type="text"  name="nickname" value="{{$member->nickname}}" /></p>
            <div class="bc">
                <input type="button" value="保存"   onclick="_saveInfo({{$member->id}})"/>
                <input type="button" value="取消" />
            </div>
        </form>
    </div>
    <!--高级设置修改-->
    <div class="xg">
        <div class="clearfix"><a href="#" class="fr gb"><img src="img/icon4.png"/></a></div>
        <h3>切换账号地区</h3>
        <form action="#" method="get">
            <p><label>姓名：</label><input type="text"   value="六六六" /></p>
            <div class="bc">
                <input type="button" value="保存" />
                <input type="button" value="取消" />
            </div>
        </form>
    </div>
    <!--修改头像-->
    <div class="avatar">
        <div class="clearfix"><a href="#" class="fr gb"><img src="img/icon4.png"/></a></div>
        <h3>修改头像</h3>
        <form action="#" method="get">
            <h4>请上传图片</h4>
            <input type="button" value="上传头像" />
            <p>jpg或png，大小不超过2M</p>
            <input type="submit" value="提交" />
        </form>
    </div>
    <script src="js/user.js" type="text/javascript" charset="utf-8"></script>
@endsection

@section('my-js')

    <script>
        function _saveInfo(member_id){
            var nickname = $(':input[name=nickname]').val();
            // console.log(nickname);return;
            $.ajax({
                url:'/service/editInfo',
                type:'post',
                data:{member_id:member_id,nickname:nickname,_token:"{{csrf_token()}}"} ,
                dataType:'json',
                success:function (res) {
                    if(res.code==0){
                        alert(res.message);
                        window.location.reload();
                    }else {
                        alert(res.message);
                        window.location.reload();
                    }
                }

            });
        }
    </script>
@endsection