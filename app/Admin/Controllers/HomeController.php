<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\MerchantTradeBills;
use App\Models\MerchantTradePay;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dashboard')
            ->description('Description...')
            ->row(Dashboard::title())
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
    }

    //统计
    public function statistics(Content $content)
    {
        //今日交易金额
        $info['today_total_amount'] = MerchantTradePay::where('created_at','>',strtotime(date('Y-m-d',time())) )
            ->where(['out_pay_status'=>0])->sum('total_amount');
        //今日收益金额
        $info['today_charges_amount'] = MerchantTradeBills::where('created_at','>',strtotime(date('Y-m-d',time() )))->where('bill_type','openpay')->sum('charges_amount');
        //待结算金额
        $info['today_total_amount_wait'] = MerchantTradePay::where(['out_pay_status'=>0,'status'=>'wait'])->sum('total_amount');
        //申请提现金额
        $info['withdraw'] = MerchantTradeBills::where(['status'=>1,'bill_type'=>'withdraw'])->sum('amount');


        //总交易金额
        $info['total_today_total_amount'] = MerchantTradePay::where(['out_pay_status'=>0])->sum('total_amount');
        //总收益金额
        $info['total_today_charges_amount'] = MerchantTradeBills::where('bill_type','openpay')->sum('charges_amount');
        //总结算金额
        $info['total_today_total_amount_wait'] = MerchantTradePay::where(['out_pay_status'=>0,'status'=>'end'])->sum('total_amount');
        //总提现金额
        $info['total_withdraw'] = MerchantTradeBills::where(['status'=>0,'bill_type'=>'withdraw'])->sum('amount');

        return $content
            ->title('财务统计')
            ->description('Description...')
            ->row(view('admin.statistics',['info'=>$info]));
    }
}
