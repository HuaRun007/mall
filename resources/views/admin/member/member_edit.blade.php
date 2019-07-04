@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="L_nickname" class="layui-form-label">
                    昵称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_nickname" name="nickname" required="" lay-verify="nickname"
                           autocomplete="off" class="layui-input" value="{{$member_data->nickname}}">
                    <input type="hidden" name="member_id" value="{{$member_data->id}}">
                </div>

            </div>
            <div class="layui-form-item">
                <label for="L_phone" class="layui-form-label">
                    手机号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_phone" name="phone" required=""
                           autocomplete="off" class="layui-input" value="{{$member_data->phone}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    邮箱号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" required=""
                           autocomplete="off" class="layui-input" value="{{$member_data->email}}">
                </div>

            </div>
            <div class="layui-form-item">
                <label for="L_integral" class="layui-form-label">
                    积分
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_integral" name="integral" required=""
                           autocomplete="off" class="layui-input" value="{{$member_data->integral}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_status" class="layui-form-label">
                    状态
                </label>
                <div class="layui-input-inline">
                    <input type="checkbox"    lay-skin="switch" lay-text="启用|禁用"
                           lay-filter="member_edit_switch" {{$member_data->status==1 ?  'checked' : ''}}>
                    <input type="hidden" name="status" id="L_status" value="{{$member_data->status}}" >
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="edit" lay-submit="">
                    确定
                </button>
            </div>
        </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            form.on('switch(member_edit_switch)', function (data){
                $('#L_status').val(this.checked ? 1 : 0);
            });

            //监听提交
            form.on('submit(edit)', function(data){

                //发异步，把数据提交给php
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'/admin/member_change',
                    data:{data:data.field,_token:"{{csrf_token()}}"},
                    success:function (result) {
                            if(result.code!=0){
                                layer.alert(result.message, {icon: 5},function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    window.parent.location.reload();
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });
                                return false;
                            }else{
                                layer.alert(result.message, {icon: 6},function () {
                                    // 获得frame索引
                                    var index = parent.layer.getFrameIndex(window.name);
                                    window.parent.location.reload();
                                    //关闭当前frame
                                    parent.layer.close(index);
                                });
                                return false;
                            }
                    },
                    error:function () {
                        
                    }
                });

                return false;
            });


        });
    </script>
    {{--<script>var _hmt = _hmt || []; (function() {--}}
            {{--var hm = document.createElement("script");--}}
            {{--hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";--}}
            {{--var s = document.getElementsByTagName("script")[0];--}}
            {{--s.parentNode.insertBefore(hm, s);--}}
        {{--})();</script>--}}
@endsection