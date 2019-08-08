

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 网站用户</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/style/admin.css')}}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-admin" data-type="trade_withdraw">提现申请</button>
            </div>

            <table id="LAY-list" lay-filter="LAY-list"></table>
            <script type="text/html" id="statusTpl">
                @{{#  if(d.status == 'success'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">成功</button>
                @{{#  } }}
                @{{#  if(d.status == 'wait'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">等待中</button>
                @{{#  } }}
                @{{#  if(d.status == 'failure'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">失败</button>
                @{{#  } }}
                @{{#  if(d.status == 'cancel'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">取消</button>
                @{{#  } }}
            </script>
        </div>
    </div>
</div>

<script src="{{URL::asset('merchantadmin/layui/layui.js')}}"></script>
<script>
    layui.config({
        base: '../../../merchantadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'trade_withdraw', 'table'], function(){
        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin
            ,table = layui.table;

        //监听搜索
        form.on('submit(LAY-user-front-search)', function(data){
            var field = data.field;

            //执行重载
            table.reload('LAY-user-manage', {
                where: field
            });
        });
        //事件
        var active = {
            trade_withdraw: function(){
                layer.open({
                    type: 2
                    ,title: '申请提现'
                    ,content: 'trade-withdraw-application'
                    ,area: ['400px', '350px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submitID = 'LAY-submit'
                            ,submit = layero.find('iframe').contents().find('#'+ submitID);

                        //监听提交
                        iframeWindow.layui.form.on('submit('+ submitID +')', function(data){
                            var field = data.field; //获取提交的字段

                            //提交 Ajax 成功后，静态更新表格中的数据
                            admin.req({
                                url: layui.setter.api_domain + layui.setter.api_list.tradeWithdrawApplication
                                ,data:field
                                ,done: function(res){
                                    console.log(res)
                                    table.reload('LAY-list'); //数据刷新
                                    layer.close(index);     //关闭弹层
                                }
                            });

                        });

                        submit.trigger('click');
                    }
                });
            }
        }
        $('.layui-btn.layuiadmin-btn-admin').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
