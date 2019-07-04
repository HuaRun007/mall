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
            <h2>管理员 <span style="color: red">【{{$user->username}}】</span>所拥有的权限</h2>
        </div>
        <div class="layui-card-body">
            <form action="" method="post" class="layui-form">
                {{csrf_field()}}
                {{method_field('put')}}
                @forelse($permissions as $first)
                    <dl class="cate-box">
                        <dt>
                            <div class="cate-first"><input id="menu{{$first['id']}}" type="checkbox" name="permissions[]" value="{{$first['id']}}" title="{{$first['display_name']}}" lay-skin="primary" {{$first['own']??''}} disabled ></div>
                        </dt>
                        @if(isset($first['_child']))
                            @foreach($first['_child'] as $second)
                                <dd>
                                    <div class="cate-second"><input id="menu{{$first['id']}}-{{$second['id']}}" type="checkbox" name="permissions[]" value="{{$second['id']}}" title="{{$second['display_name']}}" lay-skin="primary" {{$second['own']??''}} disabled></div>
                                    @if(isset($second['_child']))
                                        <div class="cate-third">
                                            @foreach($second['_child'] as $thild)
                                                <input type="checkbox" id="menu{{$first['id']}}-{{$second['id']}}-{{$thild['id']}}" name="permissions[]" value="{{$thild['id']}}" title="{{$thild['display_name']}}" lay-skin="primary" {{$thild['own']??''}} disabled>
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
            </form>
        </div>
    </div>
@endsection


