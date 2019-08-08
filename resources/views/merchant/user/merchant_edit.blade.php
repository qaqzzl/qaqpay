

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>设置我的资料</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{URL::asset('merchantadmin/style/admin.css')}}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">设置我的资料</div>
                <div class="layui-card-body" pad15>

                    <div class="layui-form " lay-filter="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户账号</label>
                            <div class="layui-input-block">
                                <input type="text" name="account" value="" readonly class="layui-input">
                                <div class="layui-form-mid layui-word-aux">不可修改</div>
                            </div>

                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" value="" lay-verify="name" autocomplete="off" placeholder="请输入商户名称" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">手机</label>
                            <div class="layui-input-block">
                                <input type="text" name="phone" value="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">邮箱</label>
                            <div class="layui-input-block">
                                <input type="text" name="email" value="" lay-verify="email" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户秘钥</label>
                            <div class="layui-input-block">
                                <input type="text" name="secret_key" value="" lay-verify="secret_key" autocomplete="off" placeholder="请输入商户秘钥" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">当前密码</label>
                            <div class="layui-input-block">
                                <input type="password" name="password" value="" lay-verify="pass" autocomplete="off" placeholder="修改资料需要填写密码" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="setmyinfo">确认修改</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::asset('merchantadmin/layui/layui.js')}}"></script>
<script>
    layui.config({
        base: '../../../merchantadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form'], function () {
        var $ = layui.$
            ,admin = layui.admin
            ,setter = layui.setter
            ,form = layui.form;

        admin.req({
            url: layui.setter.api_domain + setter.api_list.merchantInfo
            ,done: function(result){
                $("input[name=account]").val(result.data.account);
                $("input[name=name]").val(result.data.name);
                $("input[name=phone]").val(result.data.phone);
                $("input[name=email]").val(result.data.email);
                $("input[name=secret_key]").val(result.data.secret_key);
                form.render();
            }
        });

        form.verify({
            name: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                    return '用户名不能有特殊字符';
                }
                if(/(^\_)|(\__)|(\_+$)/.test(value)){
                    return '用户名首尾不能出现下划线\'_\'';
                }
                if(/^\d+\d+\d$/.test(value)){
                    return '用户名不能全为数字';
                }
            }

            //我们既支持上述函数式的方式，也支持下述数组的形式
            //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
            ,pass: [
                /^[\S]{6,12}$/
                ,'密码必须6到12位，且不能出现空格'
            ]

            //确认密码
            ,repass: function(value){
                if(value !== $('#LAY_password').val()){
                    return '两次密码输入不一致';
                }
            }
        });

        form.on('submit(setmyinfo)', function(obj){
            //提交修改
            admin.req({
                url: layui.setter.api_domain + setter.api_list.merchantInfoUpdate
                ,data: obj.field
                ,done: function( result ){
                    layui.layer.msg("修改成功")
                    location.reload()
                }
            });
            return false;
        });
    });
</script>
</body>
</html>