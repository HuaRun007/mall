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
        <table class="layui-table" lay-data="{url:'/admin/getdelmember_list',page:true,limit:30,toolbar: '#toolbarDemo',id:'delmember_list'}" lay-filter="delmember_list">
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
            <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
        </div>
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="restore">恢复账号</a>
    </script>
    <script type="text/html" id="titleTpl">
        <input type="checkbox" name="status" value="@{{d.id}}"  disabled lay-skin="switch" lay-text="启用|禁用"  lay-filter="switch_test" @{{ d.status == 1 ?'checked' : '' }}>
    </script>
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

            //搜索
            $("#searchBtn").click(function () {
                var nickName = $("#nickname").val()
                var createdAt = $("#created_at").val();
                table.reload('delmember_list',{
                    where:{nickname:nickName,created_at:createdAt},
                    page:{curr:1}
                })
            })

            //监听工具条
            table.on('tool(delmember_list)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'restore'){
                    layer.confirm('确认恢复该账号吗？', function(index){

                        $.post("/admin/member_restore",{ids:data.id,_token: "{{csrf_token()}}"},function (result) {
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

        });
    </script>


@endsection