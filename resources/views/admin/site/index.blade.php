@extends('admin.master')

@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">站点管理</a>
        <a>
          <cite>站点设置</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>站点配置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="" method="post">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="{{ $config['title']??'' }}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('my-js')
    <script>
    </script>
@endsection