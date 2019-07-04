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
            <button class="layui-btn"  onclick="x_admin_show('添加权限','/admin/permission_create',700,500)">添加权限</button>
        </div>
        <table id="table1" class="layui-table" lay-filter="table1"></table>

    </div>
@endsection

@section('my-js')
    <!-- 操作列 -->
    <script type="text/html" id="oper-col">
        <a class="layui-btn layui-btn-xs" lay-event="permission" onclick="x_admin_show('修改权限', '/admin/permission/@{{d.id}}/edit',700,500)">修改</a>
        <a class="layui-btn layui-btn-danger" lay-event="del">删除</a>
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
                    elem: '#table1',
                    url: '/admin/getpermission_list',
                    page: false,
                    cols: [[
                        {field: 'id', title: 'ID', width:80, align: 'center'},
                        {field: 'name', title: '名称', align:''},
                        {field: 'display_name', title: '显示名称', align:'center'},
                        {field: 'description', title: '描述', align:'center'},
                        {field: 'pid', title: '父类ID', align:'center'},
                        {templet: '#oper-col', title: '操作', align:'center'}
                    ]],
                    done: function () {
                        layer.closeAll('loading');
                    }
                });
            };

            renderTable();

            $('#btn-expand').click(function () {
                treetable.expandAll('#table1');
            });

            $('#btn-fold').click(function () {
                treetable.foldAll('#table1');
            });

            $('#btn-refresh').click(function () {
                renderTable();
            });

            //监听工具条
            table.on('tool(table1)', function (obj) {
                var data = obj.data;
                var layEvent = obj.event;

                if (layEvent === 'del') {
                    layer.msg('删除' + data.id);
                } else if (layEvent === 'edit') {
                    layer.msg('修改' + data.id);
                }
            });
        });
    </script>
@endsection