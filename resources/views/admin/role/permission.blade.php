@extends('admin.master')

@section('content')
    <style>
        .cate-box{margin-bottom: 15px;padding-bottom:10px;border-bottom: 1px solid #f0f0f0}
        .cate-box dt{margin-bottom: 10px;}
        .cate-box dt .cate-first{padding:10px 20px}
        .cate-box dd{padding:0 50px}
        .cate-box dd .cate-second{margin-bottom: 10px}
        .cate-box dd .cate-third{padding:0 40px;margin-bottom: 10px}
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2 >角色 <span style="color: red">【{{$role->name}}】</span>分配权限</h2>
        </div>
        <div class="layui-card-body">
            <form action=""  class="layui-form">

                @forelse($permissions as $first)
                    <dl class="cate-box">
                        <dt>
                            <div class="cate-first"><input id="menu{{$first['id']}}" type="checkbox" name="permissions" value="{{$first['id']}}" title="{{$first['display_name']}}" lay-skin="primary" {{$first['own']??''}} ></div>
                        </dt>
                        @if(isset($first['_child']))
                            @foreach($first['_child'] as $second)
                                <dd>
                                    <div class="cate-second"><input id="menu{{$first['id']}}-{{$second['id']}}" type="checkbox" name="permissions" value="{{$second['id']}}" title="{{$second['display_name']}}" lay-skin="primary" {{$second['own']??''}}></div>
                                    @if(isset($second['_child']))
                                        <div class="cate-third">
                                            @foreach($second['_child'] as $thild)
                                                <input type="checkbox" id="menu{{$first['id']}}-{{$second['id']}}-{{$thild['id']}}" name="permissions" value="{{$thild['id']}}" title="{{$thild['display_name']}}" lay-skin="primary" {{$thild['own']??''}}>
                                            @endforeach
                                        </div>
                                    @endif
                                </dd>
                            @endforeach
                        @endif
                    </dl>
                @empty
                    <div style="text-align: center;padding:20px 0;">
                        无数据
                    </div>
                @endforelse
                <div class="layui-form-item">
                    <button type="button" class="layui-btn"  lay-submit=""  lay-filter="role_permissionUpdate" >确 认</button>
                    <a href=""  class="layui-btn"  onclick="x_admin_close()">返 回</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            form.on('checkbox', function (data) {
                var check = data.elem.checked;//是否选中
                var checkId = data.elem.id;//当前操作的选项框
                if (check) {
                    //选中
                    var ids = checkId.split("-");
                    if (ids.length == 3) {
                        //第三极菜单
                        //第三极菜单选中,则他的上级选中
                        $("#" + (ids[0] + '-' + ids[1])).prop("checked", true);
                        $("#" + (ids[0])).prop("checked", true);
                    } else if (ids.length == 2) {
                        //第二季菜单
                        $("#" + (ids[0])).prop("checked", true);
                        $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                            $(ele).prop("checked", true);
                        });
                    } else {
                        //第一季菜单不需要做处理
                        $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                            $(ele).prop("checked", true);
                        });
                    }
                } else {
                    //取消选中
                    var ids = checkId.split("-");
                    if (ids.length == 2) {
                        //第二极菜单
                        $("input[id*=" + ids[0] + '-' + ids[1] + "]").each(function (i, ele) {
                            $(ele).prop("checked", false);
                        });
                    } else if (ids.length == 1) {
                        $("input[id*=" + ids[0] + "-]").each(function (i, ele) {
                            $(ele).prop("checked", false);
                        });
                    }
                }
                form.render();
            });

            //监听提交
            form.on('submit(role_permissionUpdate)', function(data){
                var arr = {};
                $("input:checkbox[name='permissions']:checked").each(function(i){
                    arr[i] = $(this).val();
                });

                $.ajax({
                    type:'put',
                    dataType:'json',
                    url:"{{url('admin/role_permission/update',['role'=>$role])}}",
                    data:{permissions:arr, _token:"{{csrf_token()}}"},
                    success:function (result) {
                        if(result.code!=0){
                            layer.alert(result.message, {icon: 5},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                window.parent.parent.location.reload();
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                            return false;
                        }else{
                            layer.alert(result.message, {icon: 6},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                window.parent.parent.location.reload();
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

