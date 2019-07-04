@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" id="btn-refresh" href="javascript:;" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-normal" id="btn-expand">全部展开</button>
            <button class="layui-btn layui-btn-normal" id="btn-fold">全部折叠</button>
            @permission('category.create')
            <button class="layui-btn"  onclick="x_admin_show('添加分类','/admin/category_create',500,400)">添加分类</button>
            @endpermission
        </div>
        <table id="category_table" class="layui-table" lay-filter="category_table"></table>

    </div>
@endsection

@section('my-js')
    <!-- 操作列 -->
    <script type="text/html" id="oper-col">
        @permission('category.edit')
        <a class="layui-btn layui-btn-xs" lay-event="permission" onclick="x_admin_show('修改权限', '/admin/category/edit/@{{d.id}}',700,500)">修改</a>
        @endpermission

        @permission('category.del')
        <a class="layui-btn layui-btn-danger" lay-event="del">删除</a>
        @endpermission
    </script>
    <script>
        layui.config({
            base: '/adminstatic/module/'
        }).extend({
            treetable: 'treetable-lay/treetable'
        }).use(['layer', 'table', 'treetable'], function () {
            var $ = layui.jquery;
            var table = layui.table;
            var layer = layui.layer;
            var treetable = layui.treetable;

            // 渲染表格
            var renderTable = function () {
                layer.load(2);
                treetable.render({
                    treeColIndex: 1,
                    treeSpid: 0,
                    treeIdName: 'id',
                    treePidName: 'parent_id',
                    treeDefaultClose: false,
                    treeLinkage: false,
                    elem: '#category_table',
                    url: '/admin/category_list',
                    page: false,
                    cols: [[
                        {field: 'id', title: 'ID', width:80, align: 'center'},
                        {field: 'name', title: '名称', align:''},
                        {field: 'pid', title: '父类ID', align:'center'},
                        {field: 'path', title: '父类路径', align:'center'},
                        {templet: '#oper-col', title: '操作', align:'center'}
                    ]],
                    done: function () {
                        layer.closeAll('loading');
                    }
                });
            };

            renderTable();

            $('#btn-expand').click(function () {
                treetable.expandAll('#category_table');
            });

            $('#btn-fold').click(function () {
                treetable.foldAll('#category_table');
            });

            $('#btn-refresh').click(function () {
                renderTable();
            });

            //监听工具条
            table.on('tool(category_table)', function (obj) {
                var data = obj.data;
                var layEvent = obj.event;

                if (layEvent === 'del') {
                    layer.confirm('确认删除吗？', function(index) {
                        $.ajax({
                            type: 'post',
                            url: '/admin/category/delete/' + data.id,
                            data: {_token: "{{csrf_token()}}"},
                            dataType: 'json',
                            success: function (result) {
                                if (result.code != 0) {
                                    layer.alert(result.message, {icon: 5});
                                    layer.close(index);
                                    renderTable();

                                } else {
                                    layer.alert(result.message, {icon: 6});
                                    layer.close(index);
                                    renderTable();
                                }

                                return false;
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection