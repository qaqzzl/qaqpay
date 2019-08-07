/**
 
 @Name：layuiAdmin 用户管理 管理员管理 角色管理
 @Author：star1029
 @Site：http://www.layui.com/admin/
 @License：LPPL
 
 */


layui.define(['table', 'form'], function(exports){
    var $ = layui.$
        ,table = layui.table
        ,form = layui.form
        ,admin = layui.admin
        ,api_list = layui.setter.api_list
    var tableloading = layui.layer.open({       //表格第一次加载动画
        type:3
        ,offset: 't'
    });

    //管理员管理
    table.render({
        elem: '#LAY-list'
        ,page:true
        ,loading:true
        ,url: layui.setter.api_domain + api_list.tradeWithdraw
        ,method:'post'
        ,parseData: function(res){ //res 即为原始返回的数据 , 解决后台数据不匹配问题
            return {
                "code": res.code, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.data.total, //解析数据长度
                "data": res.data.data //解析数据列表
            };
        }
        ,cols: [[
            {field: 'status', title: '提现状态', templet:'#statusTpl'}
            ,{field: 'amount', title: '提现金额'}
            ,{field: 'number', title: '提现账号'}
            ,{field: 'merchant_remarks', title: '提现备注'}
            ,{field: 'created_at', title: '提现时间'}
            ,{field: 'operating_remarks', title: '提现成功/失败备注'}
        ]]
        ,done: function() {
            layui.layer.close(tableloading) ////表格第一次加载动画关闭
        }
        ,text: '对不起，加载出现异常！'
    });
    
    exports('trade_withdraw', {})
});