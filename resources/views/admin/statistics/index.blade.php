@extends('admin.common.frame')
@section('body_style_class','gray-bg mini-navbar pace-done')
@section('header')
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
                    <h5>每日登陆用户数</h5>
                </div>
                <div class="ibox-content">
                    <div class="echarts" id="echarts-login-chart"></div>
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
    <script src="/assets/js/plugins/echarts/echarts-all.js"></script>
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
            var e = echarts.init(document.getElementById("echarts-reg-chart")), a = {
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
            e.setOption(a), $(window).resize(e.resize);
            var e = echarts.init(document.getElementById("echarts-line-chart")), a = {
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
                legend: {data: [ "转化率"]},
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
            e.setOption(a), $(window).resize(e.resize);
            var e = echarts.init(document.getElementById("echarts-orders-chart")), a = {
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
            e.setOption(a), $(window).resize(e.resize);
            var e = echarts.init(document.getElementById("echarts-amount-chart")), a = {
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
            e.setOption(a), $(window).resize(e.resize);
        });
    </script>
@endsection
