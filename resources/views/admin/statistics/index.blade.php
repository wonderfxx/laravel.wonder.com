@extends('admin.common.frame')
@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
    <link href="/assets/css/reset.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
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

        .modal-body {
            padding: 0;
        }

        .modal-body .form-group {
            margin: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>统计分析</h5>
            </div>
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        {!! Form::open([
                            'role'=>'form',
                            'class'=>'form-inline',
                            'method' =>'get'
                        ]) !!}
                        <div class="form-group">
                            <input placeholder="开始日期" class="form-control layer-date" id="start" name="start"
                                   value="{!! $date_start !!}">
                        </div>
                        <div class="form-group">
                            <input placeholder="结束日期" class="form-control layer-date" id="end" name="end"
                                   value="{!! $date_end !!}">
                        </div>
                        <input class="btn btn-sm btn-success" type="submit" id='searchButton'
                               style="margin-bottom: 0;margin-left:10px;" value="日期查询">
                        {!! Form::close() !!}
                    </div>
                    <div class="clearfix hidden-xs"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">近一个月</span>
                <h5>总计营收</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">$ {!! $head_orders_total !!}</h1>
                <div class="stat-percent font-bold text-danger">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right">近一个月</span>
                <h5>付费用户</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{!! $head_pay_nums !!}</h1>
                <div class="stat-percent font-bold text-danger">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">近一个月</span>
                <h5>成单总数</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{!! $head_orders_nums !!}</h1>
                <div class="stat-percent font-bold text-danger">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">近一个月</span>
                <h5>注册用户</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{!! $head_reg_users !!}</h1>
                <div class="stat-percent font-bold text-danger">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>每日充值汇总</h5>
            </div>
            <div class="ibox-content">
                <div class="echarts" id="echarts-amount-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>每日登陆用户数</h5>
            </div>
            <div class="ibox-content">
                <div class="echarts" id="echarts-login-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>每日注册用户数</h5>
            </div>
            <div class="ibox-content">
                <div class="echarts" id="echarts-reg-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>订单转化率</h5>
            </div>
            <div class="ibox-content">
                <div class="echarts" id="echarts-line-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>每日下单/成单数量</h5>
            </div>
            <div class="ibox-content">
                <div class="echarts" id="echarts-orders-chart"></div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('footer')
    <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="/assets/js/plugins/echarts/echarts-all.js"></script>
    <script type="text/javascript">
        $("#start,#end").datepicker({
            todayBtn: "linked",
            keyboardNavigation: !1,
            forceParse: !1,
            calendarWeeks: !0,
            autoclose: !0
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var e = echarts.init(document.getElementById("echarts-login-chart")), a = {
                title: {text: ""},
                tooltip: {trigger: "axis"},
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {data: ["日登陆用户数"]},
                grid: {x: 40, x2: 40, y2: 24},
                calculable: !0,
                xAxis: [{type: "category", boundaryGap: 1, data: {!! $login_date !!}}],
                yAxis: [
                    {
                        type: "value", name: '人数', axisLabel: {formatter: "{value}"}
                    }
                ],
                series: [{
                    name: "日登陆用户数",
                    type: "bar",
                    data: {!! $login_total !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }]
            };
            e.setOption(a), $(window).resize(e.resize);
            var e1 = echarts.init(document.getElementById("echarts-reg-chart")), a1 = {
                title: {text: ""},
                tooltip: {trigger: "axis"},
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {data: ["日注册用户数"]},
                grid: {x: 40, x2: 40, y2: 24},
                calculable: !0,
                xAxis: [{type: "category", boundaryGap: 1, data: {!! $reg_date !!}}],
                yAxis: [
                    {
                        type: "value", name: '人数', axisLabel: {formatter: "{value}"}
                    }
                ],
                series: [{
                    name: "日注册用户数",
                    type: "bar",
                    data: {!! $reg_total !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }]
            };
            e1.setOption(a1), $(window).resize(e1.resize);
            var e2 = echarts.init(document.getElementById("echarts-line-chart")), a2 = {
                title: {text: ""},
                tooltip: {trigger: "axis"},
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {data: ["转化率"]},
                grid: {x: 40, x2: 40, y2: 24},
                calculable: !0,
                xAxis: [{type: "category", boundaryGap: 1, data: {!! $date !!}}],
                yAxis: [
                    {
                        type: "value", name: '转化率', axisLabel: {formatter: "{value} %"}
                    }
                ],
                series: [{
                    name: "转化率",
                    type: "line",
                    data: {!! $percent !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }]
            };
            e2.setOption(a2), $(window).resize(e2.resize);
            var e3 = echarts.init(document.getElementById("echarts-orders-chart")), a3 = {
                title: {text: ""},
                tooltip: {trigger: "axis"},
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {data: ["下单笔数", "成单笔数"]},
                grid: {x: 40, x2: 40, y2: 24},
                calculable: !0,
                xAxis: [{type: "category", boundaryGap: 1, data: {!! $date !!}}],
                yAxis: [
                    {
                        type: "value", name: '笔数', axisLabel: {formatter: "{value}"}
                    }
                ],
                series: [{
                    name: "下单笔数",
                    type: "bar",
                    data: {!! $placed_nums !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }, {
                    name: "成单笔数",
                    type: "bar",
                    data: {!! $pay_nums !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }]
            };
            e3.setOption(a3), $(window).resize(e3.resize);
            var e4 = echarts.init(document.getElementById("echarts-amount-chart")), a4 = {
                title: {text: ""},
                tooltip: {trigger: "axis"},
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {data: ["每日营收"]},
                grid: {x: 40, x2: 40, y2: 24},
                calculable: !0,
                xAxis: [{type: "category", boundaryGap: 1, data: {!! $amount_date !!}}],
                yAxis: [
                    {
                        type: "value", name: '金额(美金)', axisLabel: {formatter: "{value}"}
                    }
                ],
                series: [{
                    name: "每日营收",
                    type: "bar",
                    data: {!! $amount_total !!},
                    markPoint: {data: [{type: "max", name: "最大值"}, {type: "min", name: "最小值"}]},
                    markLine: {data: [{type: "average", name: "平均值"}]}
                }]
            };
            e4.setOption(a4), $(window).resize(e4.resize);
        });
    </script>
@endsection
