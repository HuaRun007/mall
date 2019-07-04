@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">站点管理</a>
        <a>
          <cite>首页轮播图设置</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @permission('site.manage.slide.create')
                <button class="layui-btn layui-btn-sm" onclick="x_admin_show('添加轮播图','/admin/siteimage/create',500,400)">添加轮播图</button>
                @endpermission
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @permission('site.manage.slide.del')
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endpermission
                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.image_path}}" target="_blank" title="点击查看"><img src="@{{d.image_path}}" alt="" width="280" height="100"></a>
            </script>
        </div>
    </div>
    </div>
@endsection

@section('my-js')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,url:'/admin/getsiteimageList'//数据接口
                    ,height:500
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'image_path', title: '图片',toolbar:'#thumb'}
                        ,{field: 'created_at', title: '创建时间'}
                        ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("/admin/siteimage/delete",{_token:"{{csrf_token()}}",ids:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                    layer.close(index);
                                    layer.alert(result.message, {icon: 6});
                                }else{
                                    layer.close(index);
                                    layer.alert(result.message, {icon: 5});
                                }

                                return false;
                            },'json');
                        });
                    }
                });

            })
        </script>
@endsection