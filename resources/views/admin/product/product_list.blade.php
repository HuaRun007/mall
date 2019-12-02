@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">商品管理</a>
        <a>
          <cite>商品列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input type="text" name="name" placeholder="请输入产品名" autocomplete="off" class="layui-input" id="name">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="sreach" id="product_list_sreachBtn"><i
                            class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <table class="layui-table"
               lay-data="{url:'/admin/getproductlist',page:true,limit:30,toolbar: '#toolbarDemo',id:'product_table'}"
               lay-filter="product_table">
            <thead>
            <tr>
                <th lay-data="{type:'checkbox'}">ID</th>
                <th lay-data="{field:'id', width:80, sort: true,align:'center'}">ID</th>
                <th lay-data="{field:'name', sort: true, align:'center'}">产品名称</th>
                <th lay-data="{field:'description',align:'center'}">描述</th>
                <th lay-data="{field:'price',align:'center'}">价格</th>
                <th lay-data="{field:'on_sale',align:'center', templet:'#on_saleTp'}">是否在售</th>
                <th lay-data="{field:'rating',align:'center'}">平均评分</th>
                <th lay-data="{field:'stock',align:'center'}">库存</th>
                <th lay-data="{field:'sold_count',align:'center'}">销量</th>
                <th lay-data="{field:'created_at',align:'center'}">上架时间</th>
                <th lay-data="{field:'updated_at',align:'center'}">更新时间</th>
                <th lay-data="{fixed: 'right',  align:'center', templet: '#barDemo'}">操作</th>
            </tr>
            </thead>
        </table>
        <div id="test1"></div>
    </div>
@endsection


@section('my-js')
    <script type="text/html" id="on_saleTp">
        <input type="checkbox" name="status" value="@{{d.id}}" lay-skin="switch" lay-text="在售|下架"
               lay-filter="switch_test" @{{ d.on_sale== 1 ?'checked' : '' }}>
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @permission('product.manage.create')
            <button class="layui-btn layui-btn-sm" onclick="x_admin_show('添加商品','/admin/product_create')">添加商品</button>
            @endpermission
            <button class="layui-btn layui-btn-warm" onclick="ms_save()">加入秒杀</button>
        </div>
    </script>
    <script type="text/html" id="barDemo">
        @permission('product.manage.edit')
        <a class="layui-btn layui-btn-xs" lay-event="edit"
           onclick="x_admin_show('商品编辑','/admin/product/edit/@{{d.id}}')">编辑</a>
        @endpermission
        @permission('product.manage.del')
        <a class="layui-btn layui-btn-danger" lay-event="del">删除</a>
        @endpermission
    </script>

    <script>

        layui.use('table', function () {
            var table = layui.table;
            var form = layui.form
                , layer = layui.layer;
            var $ = layui.$;

            //监听工具条
            table.on('tool(product_table)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    , layEvent = obj.event; //获得 lay-event 对应的值
                if (layEvent === 'del') {
                    layer.confirm('确认删除吗？', function (index) {
                        $.post("/admin/product/delete/" + data.id, {_token: "{{csrf_token()}}"}, function (result) {
                            if (result.code == 0) {
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.msg, {icon: 6})
                        });
                    });
                }
            });

            //搜索
            $("#product_list_sreachBtn").click(function () {
                var name = $("#name").val();
                table.reload('product_table', {
                    where: {name: name},
                    page: {curr: 1}
                })
            });
        });

        function ms_save() {
            layui.use('table', function () {
                let table = layui.table;
                let data = table.checkStatus('product_table').data;

                let form_data = [];
                $(data).each(function (key, item) {
                    let value = {product_id:item.id,stock:item.stock};
                    if (item.stock < 1) {
                        layer.msg(item.name + '库存小于1，不可加入秒杀');
                        return false;
                    }
                    form_data.push(value)
                });+

                $.ajax({
                    type: 'post',
                    url: '{{url('/admin/product/ms_add')}}',
                    data: {data:form_data,_token:"{{csrf_token()}}"},
                    dataType: 'json',
                    success: function (res) {
                        if(res.code == 0){
                            layer.msg(res.message);
                            table.reload('product_table');
                        }
                    }
                });
            })
        }
    </script>
@endsection