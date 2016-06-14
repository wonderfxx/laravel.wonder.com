@extends('admin.common.frame')
@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
    <link href="/assets/css/reset.css" rel="stylesheet">
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-bookmark" style="color: #1ab394"></i> 欢迎来到管理后台....</h5>
                    </div>
                    <div class="ibox-content">
                        <p><b>管理后台承担着正常业务的管理，非常重要，请谨慎操作！谢谢。</b></p>
                        <p><b>功能</b>：</p>
                        <ul>
                            <li>
                                <p><strong>后台用户管理</strong> - 针对所有管理人员信息的管理。</p>
                            </li>
                            <li>
                                <p><strong>操作权限管理</strong> - 赋予指定管理员特殊的权限。</p>
                            </li>
                            <li>
                                <p><strong>左侧菜单管理</strong> - 管理后台操作菜单。</p>
                            </li>
                            <li>
                                <p><strong>操作日志管理</strong> - 记录所有用户的操作记录。</p>
                            </li>
                            <li>
                                <p><strong>待续</strong>...</p>
                            </li>
                        </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection