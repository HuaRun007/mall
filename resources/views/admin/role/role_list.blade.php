@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <table class="layui-table" lay-data="{url:'/admin/getrolelist',page:true,limit:30,toolbar: '#toolbarDemo',id:'test'}" lay-filter="test">
            <thead>
            <tr>
                <th lay-data="{type:'checkbox'}">ID</th>
                <th lay-data="{field:'id', width:80, sort: true,align:'center'}">ID</th>
                <th lay-data="{field:'name', sort: true, align:'center'}">名称</th>
                <th lay-data="{field:'display_name',align:'center'}">显示名称</th>
                <th lay-data="{field:'description',align:'center' }">描述</th>
                <th lay-data="{field:'created_at',align:'center'}">创建时间</th>
                <th lay-data="{field:'updated_at',align:'center'}">更新时间</th>
                <th lay-data="{fixed: 'right',  align:'center', templet: '#barDemo'}">操作</th>
            </tr>
            </thead>
        </table>
        <div id="test1"></div>
    </div>
    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm" onclick="x_admin_show('添加角色','/admin/role_create',500,400)">添加角色</button>
            <button class="layui-btn layui-btn-danger" lay-event="getCheckLength">批量删除</button>
        </div>
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit"  onclick="x_admin_show('角色编辑','/admin/role_edit?id=@{{d.id}}',500,400)">编辑</a>
        <a class="layui-btn layui-btn-normal" lay-event="permission" onclick="x_admin_show('分配权限', '/admin/role/@{{d.id}}/permission')">分配权限</a>
        <a class="layui-btn layui-btn-danger" lay-event="del">删除</a>

    </script>

    <script>

        layui.use('table', function(){
            var table = layui.table;
            var form = layui.form
                ,layer =layui.layer;


            //监听工具条
            table.on('tool(test)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        // if(data.name == 'root'){
                        //     layer.msg('不能删除root角色',{icon:5});
                        //     return false;
                        // }
                        $.post("/admin/role/destroy",{ids:data.id,_token:"{{csrf_token()}}"},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                                layer.close(index);
                                layer.msg(result.message,{icon:6})
                            }else{
                                layer.close(index);
                                layer.msg(result.message,{icon:5})
                            }

                        },'json');
                    });
                }
            });



        });
    </script>


@endsection