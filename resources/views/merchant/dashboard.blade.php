<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/style/admin.css')}}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">交易报表</div>
                        <div class="layui-card-body">

                            <div class="layui-carousel layadmin-carousel layadmin-backlog">
                                <div carousel-item>
                                    <ul class="layui-row layui-col-space10">
                                        <li class="layui-col-xs4">
                                            <a class="layadmin-backlog-body">
                                                <h3>今日交易金额</h3>
                                                <p><cite id="today_total_amount">￥0.00</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <a class="layadmin-backlog-body">
                                                <h3>今日到账金额</h3>
                                                <p><cite id="today_arrival_amount">￥0.00</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <a onclick="layer.tips('不跳转', this, {tips: 3});" class="layadmin-backlog-body">
                                                <h3>总交易金额</h3>
                                                <p><cite id="total_trade_amount">￥0.00</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <a class="layadmin-backlog-body">
                                                <h3>已提现金额</h3>
                                                <p><cite id="total_withdraw_amount">￥0.00</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <a class="layadmin-backlog-body">
                                                <h3>提现中金额</h3>
                                                <p><cite id="total_withdraw_wait_amount">￥0.00</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <a class="layadmin-backlog-body">
                                                <h3>账户余额</h3>
                                                <p><cite style="color: #FF5722;" id="account_balances">￥0.00</cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据概览</div>
                        <div class="layui-card-body">

                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-dataview">
                                <div carousel-item id="LAY-index-dataview">
                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                --}}
            </div>
        </div>

        {{--
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">效果报告</div>
                <div class="layui-card-body layadmin-takerates">
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>转化率（日同比 28% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）</h3>
                        <div class="layui-progress-bar" lay-percent="65%"></div>
                    </div>
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>签到率（日同比 11% <span class="layui-edge layui-edge-bottom" lay-tips="下降" lay-offset="-15"></span>）</h3>
                        <div class="layui-progress-bar" lay-percent="32%"></div>
                    </div>
                </div>
            </div>

            <div class="layui-card">
                <div class="layui-card-header">实时监控</div>
                <div class="layui-card-body layadmin-takerates">
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>CPU使用率</h3>
                        <div class="layui-progress-bar" lay-percent="58%"></div>
                    </div>
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>内存占用率</h3>
                        <div class="layui-progress-bar layui-bg-red" lay-percent="90%"></div>
                    </div>
                </div>
            </div>

        </div>
        --}}
    </div>
</div>

<script src="{{URL::asset('merchantadmin/layui/layui.js?t=1')}}"></script>
<script>
    layui.config({
        base: '../../merchantadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'console'], function () {
        var $ = layui.$
            ,admin = layui.admin
            ,form  = layui.form
            ,index = layui.index
        admin.req({
            url: layui.setter.api_domain + layui.setter.api_list.tradeStatistics
            ,done: function(res){
                var info = res.data.info;
                $('#today_total_amount').html("￥"+info.today_total_amount)
                $('#today_arrival_amount').html("￥"+info.today_arrival_amount)
                $('#total_withdraw_amount').html("￥"+info.total_withdraw_amount)
                $('#total_withdraw_wait_amount').html("￥"+info.total_withdraw_wait_amount)
                $('#total_trade_amount').html("￥"+info.total_trade_amount)
                $('#account_balances').html("￥"+info.account_balances)
            }
        });
    });
</script>
</body>
</html>

