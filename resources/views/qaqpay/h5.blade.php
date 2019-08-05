<html>
<head>

</head>
<style type="text/css">
    html, body {height:100%;overflow:auto;margin: 0;}
    html{overflow-y:scroll;}
    .jiage{
        text-align: center;
        margin-top: 4em;
        font-size:6em;
        font-family:SourceHanSansCN-Bold;
        font-weight:bold;
        color:rgba(0,0,0,1);
    }
    .jiagem{
        text-align: center;
        margin-top: 1em;
        font-size:3em;
        font-family:SourceHanSansCN-Bold;
        color:rgba(0,0,0,1);
    }

    .zhifubao{
        width:366px;
        height:80px;
        background:rgba(0,153,229,1);
        border-radius:8px;
        margin-left: 31%;
        margin-top: 6em;
        font-size: 30px;
        font-family:SourceHanSansCN-Medium;
        font-weight:500;
        color:rgba(255,255,255,1);
        text-align: center;
        line-height: 80px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -150px 0 0 -200px;
        width: 400px;
    }
    .t1{
        text-align: center;
        margin-top: 15em;
        font-size:2em;
        font-family:SourceHanSansCN-Bold;
        color:rgba(0,0,0,1);
    }
    .t2{
        text-align: center;
        margin-top: 1.5em;
        font-size:2em;
        font-family:SourceHanSansCN-Bold;
        color:rgba(0,0,0,1);
        display: inline-block;
    }
    .t3{
        color:#FF6271FF;
        text-align: center;
        margin-top: 1.5em;
        font-size:2em;
        font-family:SourceHanSansCN-Bold;
        display: inline-block;
    }
    .d1{
        text-align: center;
    }
</style>
<body  >
<div class="jiage">￥{{$total_amount}}</div>
<div class="jiagem">商品价格</div>
<div class="zhifubao" style="{{$total_amount=='alipayh5'?'display: block;':''}}" >支付宝支付</div>
<div class="zhifubao" style="{{$total_amount=='wechath5'?'background:rgba(40,194,40,1); display: none;':''}}">微信支付</div>
<div class="t1">快捷充值，10秒到账</div>
<div class="d1">
    <p class="t2">支付遇到问题？</p>

    <p class="t3">联系客服</p>
</div>
</body>

<script type="text/javascript">

</script>
</html>