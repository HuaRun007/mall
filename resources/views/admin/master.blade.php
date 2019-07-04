<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/adminstatic/css/font.css">
    <link rel="stylesheet" href="/adminstatic/css/xadmin.css">
    <script type="text/javascript" src="/adminstatic/js/jquery.min.js"></script>
    <script src="/adminstatic/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/adminstatic/js/xadmin.js"></script>
    <script type="text/javascript" src="/adminstatic/js/cookie.js"></script>
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body>
@yield('content')

</body>
@yield('my-js')
</html>