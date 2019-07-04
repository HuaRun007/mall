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
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="下单日期" name="start" id="created_at">
          <div class="layui-input-inline">
            <select id="paystatus">
              <option value="">支付状态</option>
              <option value="1">已支付</option>
              <option value="2">未支付</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select id="payment_method">
              <option value="">支付方式</option>
              <option value="1">支付宝</option>
              <option value="2">微信</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select id="status">
              <option value="">订单状态</option>
              <option value="1">已提交</option>
              <option value="2">待发货</option>
              <option value="3">已发货</option>
              <option value="4">待收货</option>
              <option value="5">已完成</option>
              <option value="0">已作废</option>
            </select>
          </div>
          <input type="text" name="no"  id="no" placeholder="请输入订单号" autocomplete="off" class="layui-input">
          <button type="button" class="layui-btn"  lay-submit="" id="order_serach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <table class="layui-table" lay-data="{url:'/admin/getorderlist',page:true,limit:30,id:'order_list'}" lay-filter="order_list">
        <thead>
        <tr>
          <th lay-data="{type:'checkbox'}">ID</th>
          <th lay-data="{field:'no', align:'center',width:200}">订单编号</th>
          <th lay-data="{field:'member_name', align:'center'}">收货人</th>
          <th lay-data="{field:'total_amount',align:'center'}">总金额</th>
          <th lay-data="{field:'paystatus',align:'center', templet:function(d){if(d.paystatus==1){return '已支付';}else{return '未支付';}} }">支付状态</th>
          <th lay-data="{field:'payment_method',align:'center', templet:function(d){if(d.payment_method==1){return '支付宝';}else{return '微信';}} }">支付方式</th>
          <th lay-data="{field:'status',align:'center', templet:function(d){
                switch(d.status){
                  case 1:
                    return '已提交';
                  break;
                  case 2:
                    return '待发货';
                  break;
                  case 3:
                    return '已发货';
                  break;
                  case 4:
                    return '待收货';
                  break;
                  case 5:
                    return '已完成';
                  break;
                }
          } }">订单状态</th>
          <th lay-data="{field:'created_at',align:'center'}">下单时间</th>
          <th lay-data="{fixed: 'right',  align:'center', templet: '#order_bar'}">操作</th>
        </tr>
        </thead>
      </table>

    </div>
@endsection

@section('my-js')
  <script type="text/html" id="order_bar">
      @permission('order.manage.look')
      <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="show" onclick="x_admin_show('查看订单','/admin/order/show/@{{d.id}}')">查看</a>
      @endpermission
      @permission('order.manage.edit')
      <a class="layui-btn layui-btn-xs" lay-event="edit"  onclick="x_admin_show('订单编辑','/admin/order/edit/@{{d.id}}')">编辑</a>
      @endpermission
  </script>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#created_at' //指定元素
        });

      });

      layui.use('table', function(){
          var $ = layui.jquery;
          var table = layui.table;
          var form = layui.form
              ,layer =layui.layer;
          //搜索
          $("#order_serach").click(function () {
              var created_at = $("#created_at").val()
              var no = $("#no").val();
              var status = $("#status").val();
              var paystatus = $("#paystatus").val();
              var payment_method = $("#payment_method").val();

              table.reload('order_list',{
                  where:{created_at:created_at,no:no,status:status,paystatus:paystatus,payment_method:payment_method},
                  page:{curr:1}
              })
          });
      });


    </script>
@endsection
