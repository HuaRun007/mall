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
        <div class="layui-row">
            <div class="layui-form layui-col-md12 x-so">
                <input class="layui-input"  autocomplete="off" placeholder="创建时间" name="created_at" id="created_at">
                <input type="text" name="nickname"  placeholder="请输入用户名" autocomplete="off" class="layui-input" id="nickname">
                <button type="button" class="layui-btn" id="searchBtn"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </div>
        <table class="layui-table" lay-data="{url:'/admin/getmember_list',page:true,limit:30,toolbar: '#toolbarDemo',id:'test'}" lay-filter="test">
            <thead>
            <tr>
                <th lay-data="{type:'checkbox'}">ID</th>
                <th lay-data="{field:'id', width:80, sort: true,align:'center'}">ID</th>
                <th lay-data="{field:'nickname', sort: true, align:'center'}">用户名</th>
                <th lay-data="{field:'phone',align:'center'}">电话</th>
                <th lay-data="{field:'email',align:'center' }">邮箱</th>
                <th lay-data="{field:'created_at',align:'center'}">创建时间</th>
                <th lay-data="{field:'status',align:'center', templet: '#titleTpl'}">状态</th>
                <th lay-data="{fixed: 'right',  align:'center', templet: '#barDemo'}"></th>
            </tr>
            </thead>
        </table>
        <div id="test1"></div>
    </div>
    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
            <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        </div>
    </script>
    <script type="text/html" id="barDemo">
        @permission('member.manage.edit')
        <a class="layui-btn layui-btn-xs" lay-event="edit"  onclick="x_admin_show('会员编辑','/admin/member_edit?id=@{{d.id}}',500,400)">编辑</a>
        @endpermission
        @permission('member.manage.del')
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        @endpermission
        <a class="layui-btn layui-btn-green layui-btn-xs" lay-event="reset">重置密码</a>
    </script>
    @permission('member.manage.change')
    <script type="text/html" id="titleTpl">
        <input type="checkbox" name="status" value="@{{d.id}}"  lay-skin="switch" lay-text="启用|禁用"  lay-filter="switch_test" @{{ d.status == 1 ?'checked' : '' }}>
    </script>
    @endpermission
    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#created_at' //指定元素
            });

        });
    </script>

    <script>
        layui.use('table', function(){
            var table = layui.table;
            var form = layui.form
                ,layer =layui.layer;

            //头工具栏事件
            table.on('toolbar(test)', function(obj){
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                    case 'getCheckData':
                        var data = checkStatus.data;
                        layer.alert(JSON.stringify(data));
                        break;
                    case 'getCheckLength':
                        var data = checkStatus.data;
                        layer.msg('选中了：'+ data.length + ' 个');
                        break;
                    case 'isAll':
                        layer.msg(checkStatus.isAll ? '全选': '未全选');
                        break;
                };
            });


            //监听会员状态开关
            form.on('switch(switch_test)', function(obj){
                var index_sms;
                var id = $(this).val();
                var change_value =this.checked ? '1' : '0';

                $.ajax({
                    type:'POST',
                    url:'/admin/changememberstatus',
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

            //搜索
            $("#searchBtn").click(function () {
                var nickName = $("#nickname").val()
                var createdAt = $("#created_at").val();
                table.reload('test',{
                    where:{nickname:nickName,created_at:createdAt},
                    page:{curr:1}
                })
            });

            //监听工具条
            table.on('tool(test)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){

                        $.post("/admin/member_del",{ids:data.id,_token: "{{csrf_token()}}"},function (result) {
                            setTimeout(function(){
                                layer.close(index);
                                layer.msg(result.message);
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                },700);

                        },'json');

                    });
                }else if(layEvent == 'reset'){
                    layer.confirm('确定重置用户密码？', function(index){
                        $.get("/admin/ResetPassword/"+data.id,function (result) {
                            setTimeout(function(){
                                layer.close(index);
                                layer.msg(result.message);
                            },700);

                        },'json');

                    });
                }
            });

        });
    </script>


@endsection