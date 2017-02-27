<!--_meta 作为公共模版分离出去-->
@include('admin.layouts._meta')
<!--/meta 作为公共模版分离出去-->

    <title>H-ui.admin v3.0</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<!--_header 作为公共模版分离出去-->
@include('admin.layouts._header')
<!--/_header 作为公共模版分离出去-->

<!--_menu 作为公共模版分离出去-->
@include('admin.layouts._menu')
<!--/_menu 作为公共模版分离出去-->

@yield('content')

<!--_footer 作为公共模版分离出去-->
@include('admin.layouts._foot')
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->


@yield('my-js')
<!--/请在上方写此页面业务相关的脚本-->


</body>
</html>