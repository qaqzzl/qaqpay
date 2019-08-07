
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 管理员 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/layui/css/layui.css')}}" media="all">
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">提现账号</label>
        <div class="layui-input-inline">
            <input type="text" name="number" lay-verify="required" placeholder="请输入提现账号" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提现金额</label>
        <div class="layui-input-inline">
            <input type="text" name="amount" lay-verify="required" placeholder="最多可提现:{{$account_balances}}" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提现备注</label>
        <div class="layui-input-inline">
            <textarea placeholder="请输入提现备注" class="layui-textarea" name="merchant_remarks"></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="LAY-submit" id="LAY-submit" value="确认">
    </div>
</div>

<script src="{{URL::asset('merchantadmin/layui/layui.js')}}"></script>
<script>
    layui.config({
        base: '../../../merchantadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form'], function(){
        var $ = layui.$
            ,form = layui.form

        form.render();
    })
</script>
</body>
</html>