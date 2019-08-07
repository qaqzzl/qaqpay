<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div>
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>￥{{$info['today_total_amount']}}</h3>
                            <p>今日交易金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>￥{{$info['today_charges_amount']}}</h3>
                            <p>今日收益金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>￥{{$info['today_total_settlement']}}</h3>
                            <p>今日结算金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>￥{{$info['withdraw']}}</h3>
                            <p>申请提现金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </section>
        <!-- /.content -->

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <h3>￥{{$info['total_today_total_amount']}}</h3>
                            <p>总交易金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <h3>￥{{$info['total_today_charges_amount']}}</h3>
                            <p>总收益金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <h3>￥{{$info['total_today_total_settlement']}}</h3>
                            <p>总结算金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <h3>￥{{$info['total_withdraw']}}</h3>
                            <p>已提现金额</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </section>
        <!-- /.content -->
    </div>

</div>

</body>
</html>
