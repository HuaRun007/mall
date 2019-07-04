@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">管理员</a>
        <a>
          <cite>管理员列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input class="layui-input" placeholder="开始日" name="start" id="start">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input" id="username">
                <button type="button" class="layui-btn"  lay-submit="" lay-filter="sreach"  id="user_list_sreachBtn"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <table class="layui-table" lay-data="{url:'/admin/getuserlist',page:true,limit:30,toolbar:'#user_tab',id:'user_list'}" lay-filter="user_list">
            <thead>
            <tr>
                <th lay-data="{type:'checkbox'}">ID</th>
                <th lay-data="{field:'id', width:80, sort: true,align:'center'}">ID</th>
                <th lay-data="{field:'username', sort: true, align:'center'}">登录名</th>
                <th lay-data="{field:'name', sort: true, align:'center'}">昵称</th>
                <th lay-data="{field:'email',align:'center' }">邮箱</th>
                <th lay-data="{field:'phone',width:130,align:'center'}">电话</th>
                <th lay-data="{field:'created_at',align:'center'}">创建时间</th>
                <th lay-data="{field:'status',align:'center', templet: '#titleTpl'}">状态</th>
                <th lay-data="{fixed: 'right', align:'center', templet: '#barDemo'}"></th>
            </tr>
            </thead>
        </table>

    </div>
@endsection

@section('my-js')
    <script type="text/html" id="barDemo">
        <div class="layui-btn-container">
            <a class="layui-btn layui-btn-xs" lay-event="edit"  onclick="x_admin_show('管理员账号编辑','/admin/user_edit?id=@{{d.id}}')">编辑</a>
            <a class="layui-btn layui-btn-normal" lay-event="role" onclick="x_admin_show('管理员【@{{d.name}}】分配角色', '/admin/user_role/@{{ d.id }}')">角色</a>
            <a class="layui-btn layui-btn-warm" lay-event="permission" onclick="x_admin_show('管理员【@{{d.name}}】权限','/admin/user_permission?id=@{{d.id}}')">权限</a>
            @role('root')
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            @endrole
        </div>

    </script>
    <script type="text/html" id="titleTpl">
        <input type="checkbox" name="status" value="@{{d.id}}"  lay-skin="switch" lay-text="启用|禁用"  lay-filter="switch_test" @{{ d.status == 1 ?'checked' : '' }}>
    </script>
    <script type="text/html" id="user_tab">
        <div class="layui-btn-container">
            <button class="layui-btn" onclick="x_admin_show('添加用户','/admin/user_create',500,600)"><i class="layui-icon"></i>添加管理员</button>
            <button class="layui-btn layui-btn-danger" lay-event="delAll"><i class="layui-icon"></i>批量删除</button>
        </div>
    </script>

    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        layui.use('table', function(){
            var table = layui.table;
            var form = layui.form
                ,layer =layui.layer;

            //搜索
            $("#user_list_sreachBtn").click(function () {
                var userName = $("#username").val()
                var createdAt = $("#start").val();
                table.reload('user_list',{
                    where:{username:userName,created_at:createdAt},
                    page:{curr:1}
                })
            });



            //监听事件
            table.on('toolbar(user_list)', function(obj){
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                    case 'delAll':
                        if(checkStatus.data.length == 0){
                            layer.alert('未选中任何行！',{icon:5});
                        }else{
                            delAll(checkStatus.data);
                        }
                        break;
                }
            });

            //监听工具条
            table.on('tool(user_list)', function(obj){
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    if(data.username == 'root'){
                        layer.alert('不能删除root账号！',{icon: 2});
                        return false;
                    }
                    layer.confirm('确认删除吗？', function(index){
                        $.post("/admin/user_del",{data:data.id,_token: "{{csrf_token()}}"},function (result) {
                            setTimeout(function(){
                                layer.close(index);
                                layer.msg(result.message);
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                            },700);

                        },'json');

                    });
                }
            });


            //监听管理员账户状态开关
            form.on('switch(switch_test)', function(obj){
                var index_sms;
                var id = $(this).val();
                var change_value =this.checked ? '1' : '0';

                $.ajax({
                    type:'POST',
                    url:'/admin/changeuserstatus',
                    data:{id:id,change_value:change_value,_token:"{{csrf_token()}}" },
                    dataType: 'json',
                    beforeSend:function () {
                        index_sms = layer.msg('正在切换中，请稍候',{icon: 16,time:800,shade:0.8});
                    },
                    error: function(data){
                        console.log(data);
                        layer.msg('数据异常，操作失败！');
                    },
                    success:function (data) {
                        if(data.code==0){ setTimeout(function(){
                            layer.close(index_sms);
                            layer.msg('操作成功！');},1000);
                        }else{
                            console.log(data);
                            layer.msg('数据异常，操作失败！');
                        }
                    },

                });

            });



        });




        function delAll (data) {
            layer.confirm('确认要删除吗？',function(index){
                //判断账号中有没有root账号 不能删除
                var enable = false;
                $(data).each(function (i,v) {
                   if(v.username=='root'){
                       enable = true;
                       return false;
                   }
                });

                if(enable){
                    layer.alert('不能删除root账号！',{icon: 2});
                    return false;
                }

                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    type:'post',
                    url : '/admin/user_del',
                    data: {data:data,_token: "{{csrf_token()}}"},
                    dataType: 'json',
                    success:function (result) {
                        if(result.code==0){
                            layer.msg('删除成功', {icon: 1});
                            $(".layui-form-checked").not('.header').parents('tr').remove();
                        }else{
                            layer.msg(result.msg, {icon: 2});
                        }
                    }
                });

            });
        }
    </script>
@endsection