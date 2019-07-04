@extends('admin.master')

@section('content')
    <div class="x-body">
        <form class="layui-form" >
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    父类
                </label>
                <div class="layui-input-inline">
                    <select name="parent_id" lay-verify="required">
                        <option value="">请选择父类</option>
                        <option value="0" {{$permission_data->parend_id==0? 'selected' : ''}}>顶级权限</option>
                        @forelse($permission as $item)
                            <option value="{{$item['id']}}" {{$permission_data->parent_id==$item['id'] ? 'selected' : ''}} >{{$item['display_name']}}</option>
                            @if(isset($item['_child']))
                                @foreach($item['_child'] as $item2)
                                    <option value="{{$item2['id']}}" {{$permission_data->parent_id==$item2['id'] ? 'selected' : ''}} >&nbsp;&nbsp;┗━━{{$item2['display_name']}}</option>
                                    @if(isset($item2['_child']))
                                        @foreach($item2['_child'] as $item3)
                                            <option value="{{$item3['id']}}" {{$permission_data->parent_id==$item3['id'] ? 'selected' : ''}} >&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{$item3['display_name']}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_name" class="layui-form-label">
                    权限名称
                </label>
                <div class="layui-input-inline">
                    <input type="hidden"  name="id" value="{{$permission_data->id}}" >
                    <input type="text" id="L_name" name="name" lay-verify="required"
                           autocomplete="off" class="layui-input" value="{{$permission_data->name}}"  placeholder="格式如：system.manage" >
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_display_name" class="layui-form-label">
                    显示名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_display_name" name="display_name" required="" lay-verify="required"
                           autocomplete="off" class="layui-input" value="{{$permission_data->display_name}}">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_description" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-inline">
                    <textarea name="description" class="layui-textarea">{{$permission_data->description}}</textarea>
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" class="layui-btn" lay-filter="permission_add" lay-submit="">
                    修改权限
                </button>
            </div>
        </form>
    </div>

@endsection

@section('my-js')
    <script>
        layui.use(['form','layer'],function () {
            var form = layui.form
                ,layer = layui.layer;
            //监听提交
            form.on('submit(permission_add)',function(data){

                $.ajax({
                    type: 'post',
                    url : '/admin/permission_update',
                    data: {data:data.field, _token:"{{csrf_token()}}"},
                    dataType : 'json',
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

                        return false;
                    }

                });
            });
        });
    </script>
@endsection