

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
{{--        <div class="layui-form layui-card-header layuiadmin-card-header-auto">--}}
{{--            <div class="layui-form-item">--}}
{{--                <div class="layui-inline">--}}
{{--                    <label class="layui-form-label">ID</label>--}}
{{--                    <div class="layui-input-block">--}}
{{--                        <input type="text" name="id" placeholder="请输入" autocomplete="off" class="layui-input">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-inline">--}}
{{--                    <label class="layui-form-label">用户名</label>--}}
{{--                    <div class="layui-input-block">--}}
{{--                        <input type="text" name="username" placeholder="请输入" autocomplete="off" class="layui-input">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-inline">--}}
{{--                    <label class="layui-form-label">邮箱</label>--}}
{{--                    <div class="layui-input-block">--}}
{{--                        <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-inline">--}}
{{--                    <label class="layui-form-label">性别</label>--}}
{{--                    <div class="layui-input-block">--}}
{{--                        <select name="sex">--}}
{{--                            <option value="0">不限</option>--}}
{{--                            <option value="1">男</option>--}}
{{--                            <option value="2">女</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-inline">--}}
{{--                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="LAY-user-front-search">--}}
{{--                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="layui-card-body">

            <table id="LAY-list" lay-filter="LAY-list"></table>

            <script type="text/html" id="billtypeTpl">
                @{{#  if(d.bill_type == 'openpay'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">支付</button>
                @{{#  } }}
                @{{#  if(d.bill_type == 'withdraw'){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">提现</button>
                @{{#  } }}
            </script>
            <script type="text/html" id="statusTpl">
                @{{#  if(d.status == 0){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">成功</button>
                @{{#  } }}
                @{{#  if(d.status == 1){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">等待</button>
                @{{#  } }}
                @{{#  if(d.status == 2){ }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">失败</button>
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
    }).use(['index', 'trade_bills', 'table'], function(){
        var $ = layui.$
            ,form = layui.form
            ,table = layui.table;

        //监听搜索
        form.on('submit(LAY-user-front-search)', function(data){
            var field = data.field;

            //执行重载
            table.reload('LAY-user-manage', {
                where: field
            });
        });

    });
</script>
</body>
</html>
