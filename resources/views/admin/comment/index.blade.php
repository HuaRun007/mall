@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">商品管理</a>
        <a>
          <cite>商品列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <table class="layui-table" lay-data="{url:'/admin/gtcommentlist',page:true,limit:30,toolbar: '#toolbarDemo',id:'comment_list'}" lay-filter="product_table">
            <thead>
            <tr>
                <th lay-data="{field:'nickname', sort: true, align:'center'}">用户昵称</th>
                <th lay-data="{field:'name', sort: true, align:'center'}">产品名称</th>
                <th lay-data="{field:'content',align:'center'}">评论内容</th>
                <th lay-data="{field:'created_at',align:'center'}">评论时间</th>
                {{--<th lay-data="{fixed: 'right',  align:'center', templet: '#barDemo'}">操作</th>--}}
            </tr>
            </thead>
        </table>
        <div id="test1"></div>
    </div>
@endsection


@section('my-js')

    <script>

        layui.use('table', function(){
            var table = layui.table;
            var form = layui.form
                ,layer =layui.layer;
            var $ = layui.$;




        });
    </script>
@endsection