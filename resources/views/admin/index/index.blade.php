@extends('admin.master')
@section('title','后台管理系统')
@section('content')
<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="./index">AdminSystem v1.0</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
                <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
                <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">{{$user->username}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
                <dd><a href="/admin/logout">切换帐号</a></dd>
                <dd><a href="/admin/logout">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="/" target="_blank">前台首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            @permission('system.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ae;</i>
                    <cite>系统管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/user">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/admin/role">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/admin/permission">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/admin/menu">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>菜单管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            @permission('member.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>会员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="/admin/member_list">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>账号管理</cite>

                        </a>
                    </li >
                    <li>
                        <a _href="/admin/delmembers_list">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>已删除账号</cite>

                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            @permission('category.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe699;</i>
                    <cite>分类管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/category">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>多级分类</cite>
                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            @permission('product.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6cb;</i>
                    <cite>商品管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/product">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>商品列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            @permission('order.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>订单管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/order">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>订单列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            @permission('site.manage')
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe811;</i>
                    <cite>站点管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/site">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>站点设置</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/admin/siteimage">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>首页轮播图设置</cite>
                        </a>
                    </li >
                </ul>
            </li>
            @endpermission
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe69b;</i>
                    <cite>评论管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/admin/comment">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>评论列表</cite>
                        </a>
                    </li >
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd>
            </dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='/admin/welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
        <div id="tab_show"></div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Author ©2019 华润 </div>
</div>
<!-- 底部结束 -->
@endsection()