@extends('admin.common.frame')@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
    <link href="/assets/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <style>
        .inmodal .modal-header {
            padding: 15px;
        }

        .modal-header .close {
            margin-top: 3px;
        }

        .inmodal .modal-title {
            font-weight: bold;
            font-size: 20px;
        }
        .modal-body{ padding: 0;}
        .modal-body .form-group {
            margin: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>@yield('nav_title')</h5>
            </div>
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        @section('body_section')
                        @show
                        <table id="dataTableLabel" data-show-columns="true" data-mobile-responsive="true"></table>
                    </div>
                    <div class="clearfix hidden-xs"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal " id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">×</span> <span class="sr-only">关闭</span>
                    </button>
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <iframe src=""  id='myModalIframe' frameborder="0" height="400" width="100%"></iframe>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-white btn-sm" type="button">关闭</button>
                    <button class="btn btn-success btn-sm btn-submit-box" type="submit">确认保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="/assets/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/assets/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="/assets/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="/assets/js/plugins/bootstrap-table/export/bootstrap-table-export.js"></script>
    <script src="/assets/js/plugins/bootstrap-table/export/table-export.js"></script>
    <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
        var columns = {!! $headers !!},
                tableHandler = $('#dataTableLabel'),
                pageAddress = '@yield('page_address')',
                pageSearchParams = '@yield('page_search_params')';

        $(document).ready(function () {

            // 选择插件
            $('.chosen-select').chosen();

            // 数据
            tableHandler.bootstrapTable({

                // server
                sidePagination: "server", //服务端请求
                method: 'get',
                dataType: "json",
                url: '/adm/page' + pageAddress,
                queryParams: queryParams,
                responseHandler: responseHandler,

                // page
                pagination: true,
                queryParamsType: "pageSize,pageNumber," + pageSearchParams,
                pageSize: 10,
                pageNumber: 1,
                pageList: [],

                // setting
                height: $(document).outerHeight - 120,
                singleSelect: false,
                search: false,
                maintainSelected: false,
                strictSearch: false,
                clickToSelect: false,

                showToggle: true,
                showColumns: true,
                showRefresh: false,
                showExport: true,

                striped: true,
                toolbar: "#dataTableLabelToolbar",
                iconSize: "outline",
                icons: {
                    refresh: "glyphicon-repeat",
                    toggle: "glyphicon-list-alt",
                    columns: "glyphicon-list",
                    export: "glyphicon-export"
                },
                columns: columns
            });

            // 查询条件
            $('#searchButton').click(function () {
                tableHandler.bootstrapTable('refresh');
            });
            $("#myModal").on("hidden.bs.modal", function () {
                $(this).find('iframe').html("");
                $(this).find('iframe').attr("src", "");
                $(this).removeData("bs.modal");
            });
            $('#myModal').on('click','.btn-submit-box',function () {
                $("#myModalIframe")[0].contentWindow.saveButton();
            });
        });

        //返回参数
        function responseHandler(resultStr) {
            return {
                "rows": resultStr.data,
                "total": resultStr.total
            }
        }

        //查询参数
        function queryParams(params) {
            var demoArr = pageSearchParams.split(','),
                    result = {
                        pageSize: params.pageSize,
                        pageNumber: params.pageNumber
                    };
            for (i in demoArr) {
                result[demoArr[i]] = $('#' + demoArr[i]).val();
            }
            return result;
        }

        //删除
        function del(ids) {
            swal({
                title: "您确定要删除这条信息吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                cancelButtonText: "取消",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: '/adm' + pageAddress + ids,
                    type: 'post',
                    dataType: 'json',
                    data: {'_method': 'DELETE', '_token': '{!! csrf_token() !!}'},
                    success: function () {
                        swal("删除成功！", "您已经永久删除了这条信息。", "success");
                        $('#searchButton').click();
                    },
                    error: function (data) {
                        var errors = data.responseJSON;
                        switch (data.status) {
                            case 422:
                                swal("删除失败！", errors.error + "，请重新尝试。", "error");
                                break;
                            default:
                                swal("删除成功！", "您已经永久删除了这条信息。", "success");
                                $('#searchButton').click();
                        }
                    }
                });
            });
        }

        //编辑
        function edit(ids) {
            var handler = $('#myModal');
            $('.btn-submit-box').show();
            handler.find('iframe').attr('src', '/adm' + pageAddress + ids + '/edit/');
            handler.modal({show: true});
        }

        //详情
        function info(ids) {
            var handler = $('#myModal');
            $('.btn-submit-box').hide();
            handler.find('iframe').attr('src', '/adm' + pageAddress + ids );
            handler.modal({show: true});
        }

        //编辑
        function add() {
            var handler = $('#myModal');
            $('.btn-submit-box').show();
            handler.find('iframe').attr('src', '/adm' + pageAddress + 'create/');
            handler.modal({show: true});
        }

    </script>
@endsection