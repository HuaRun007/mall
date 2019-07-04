@extends('admin.master')

@section('content')
        <style>
            .layui-form-checkbox span{width: 100px}
        </style>
        <div class="layui-card">
            <div class="layui-card-header layuiadmin-card-header-auto">
                <h2 >管理员 <span style="color: red">【{{$user->name}}】</span>分配角色</h2>
            </div>
            <div class="layui-card-body">
                <form class="layui-form" >
                    <div class="layui-form-item">
                        <label for="" class="layui-form-label">角色</label>
                        <div class="layui-input-block" style="width: 400px">
                            @forelse($roles as $role)
                                <input type="checkbox" name="roles" value="{{$role->id}}" title="{{$role->display_name}}" {{ $role->own ? 'checked' : ''  }} >
                            @empty
                                <div class="layui-form-mid layui-word-aux">还没有角色</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="buttion" class="layui-btn" lay-submit="" lay-filter="user_role_update">确 认</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection

@section('my-js')
    <script>
        layui.use(['layer','form'],function () {
            var form = layui.form;
            var layer = layui.layer;


            //监听提交
            form.on('submit(user_role_update)', function(data){
                //发异步，把数据提交给php

                var arr = {};
                $("input:checkbox[name='roles']:checked").each(function(i){
                    arr[i] = $(this).val();
                });

                $.ajax({
                    type:'put',
                    dataType:'json',
                    url:"{{url('admin/user/roleupdate',['user'=>$user])}}",
                    data:{roles:arr, _token:"{{csrf_token()}}"},
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
        })
    </script>
@endsection