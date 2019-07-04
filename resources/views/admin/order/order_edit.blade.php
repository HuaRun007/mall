@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>订单编号
                </label>
                <div class="layui-input-inline">
                    <input type="text" name="no" required=""
                           autocomplete="off" class="layui-input" value="{{$order_data->no}}" readonly>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
          <div class="layui-form-item">
              <label for="member_name" class="layui-form-label">
                  <span class="x-red">*</span>收货人
              </label>
              <div class="layui-input-inline">
                  <input type="text" name="member_name"  lay-verify="required"
                  autocomplete="off" class="layui-input"  value="{{$order_data->member_name}}" readonly>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="phone" class="layui-form-label">
                  <span class="x-red">*</span>手机
              </label>
              <div class="layui-input-inline">
                  <input type="text" name="phone"
                  autocomplete="off" class="layui-input" value="{{$order_data->phone}}" readonly >
              </div>
          </div>
          <div class="layui-form-item">
              <label for="address" class="layui-form-label">
                  <span class="x-red">*</span>收货地址
              </label>
              <div class="layui-input-inline">
                      <textarea placeholder="请输入内容" name="address" class="layui-textarea" {{$order_look==1 ? 'disabled' :''}}>{{$order_data->address}}</textarea>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="payment_method" class="layui-form-label">
                  <span class="x-red">*</span>支付方式
              </label>
              <div class="layui-input-inline">
                  <select name="payment_method" {{$order_look==1 ? 'disabled' :''}}>
                    <option>支付方式</option>
                    <option value="1" {{$order_data->payment_method==1?'selected':''}}>支付宝</option>
                    <option value="2" {{$order_data->payment_method==2?'selected':''}}>微信</option>
                  </select>
              </div>
          </div>
          <div class="layui-form-item layui-form-text">
              <label for="desc" class="layui-form-label">
                  订单详情
              </label>
              <div class="layui-input-block">
                  <table class="layui-table">
                    <tbody>
                    <tr>
                        <th>商品名称</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>总价</th>
                    </tr>
                    @forelse($order_data->order_detail as $item)
                      <tr>
                        <td>{{$item['product_name']}}</td>
                        <td>{{$item['number']}}</td>
                        <td>{{$item['price']/$item['number']}}</td>
                        <td>{{$item['price']}}</td>
                      </tr>
                    @empty
                        <tr>
                            <td colspan="4">无数据</td>
                        </tr>
                    @endforelse
                    </tbody>
                  </table>
              </div>
          </div>
          <div class="layui-form-item layui-form-text">
              <label for="desc" class="layui-form-label">
                  订单备注
              </label>
              <div class="layui-input-inline">
                      <textarea placeholder="请输入内容"  name="remark" class="layui-textarea" {{$order_look==1 ? 'disabled' :''}}>{{$order_data->remark}}</textarea>
              </div>
          </div>
            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">
                    订单状态
                </label>
                <div class="layui-input-block" >
                    <input type="radio" title="已提交" name="status" value="1" {{$order_data->status==1?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>
                    <input type="radio" title="待发货" name="status" value="2" {{$order_data->status==2?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>
                    <input type="radio" title="已发货" name="status" value="3" {{$order_data->status==3?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>
                    <input type="radio" title="待收货" name="status" value="4" {{$order_data->status==4?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>
                    <input type="radio" title="已完成" name="status" value="5" {{$order_data->status==5?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>
                    <input type="radio" title="已作废" name="status" value="0" {{$order_data->status==0?'checked':''}} {{$order_look==1 ? 'disabled' :''}}>

                </div>
            </div>
            @if($order_look==1)
                @else
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="order_edit">立即提交</button>
                    </div>
                </div>
                @endif

      </form>
    </div>
@endsection

@section('my-js')
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });

          //监听提交
          form.on('submit(order_edit)', function(data){
            //发异步，把数据提交给php
              $.ajax({
                  url : "{{url('/admin/order/update',['order'=>$order_data])}}",
                  type:'post',
                  data:data.field,
                  dataType:'json',
                  success:function (res) {
                      if(res.code==0){
                          layer.alert("修改成功", {icon: 6},function () {
                              // 获得frame索引
                              var index = parent.layer.getFrameIndex(window.name);
                              //关闭当前frame
                              parent.layer.close(index);
                          });
                          return false;
                      }else{
                          layer.alert("修改失败", {icon: 5},function () {
                              // 获得frame索引
                              var index = parent.layer.getFrameIndex(window.name);
                              //关闭当前frame
                              parent.layer.close(index);
                          });
                          return false;
                      }

                  }

              });
            return false;
          });
          
          
        });
    </script>
@endsection