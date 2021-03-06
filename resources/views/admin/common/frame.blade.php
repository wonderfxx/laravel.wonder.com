<!DOCTYPE html>
<html lang="@yield('lang')">
<head>
    <title>@yield('title')</title>
    <meta content="@yield('author')" name="author">
    <meta content="@yield('description')" name="description">
    <meta content="@yield('keywords')" name="keywords">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html"/><![endif]-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min.css" rel="stylesheet">
    <link href="/assets/css/theme.min.css" rel="stylesheet">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <link href="/assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <script src="/assets/js/jquery.min-2.1.4.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/layer/layer.min.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="/assets/js/action.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        //document.domain = "@yield('domain')";
    </script>
@section('header')
    {{--do something header info...--}}
@show
<body class="@yield('body_style_class')">
@section('content')
    {{--do something content info...--}}
@show
@section('footer')
    {{--do something footer info...--}}
@show
</body>
</html>