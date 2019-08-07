<?php
// 商户后台管理页面
namespace App\Http\Controllers\OpenPay;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantAdminPage extends Controller
{
    //登录
    public function login()
    {
        return view('merchant.login');
    }

    //首页
    public function index()
    {
        return view('merchant.index');
    }

    //控制面板
    public function dashboard()
    {
        return view('merchant.dashboard');
    }


    //修改商户资料

    //提现列表
    public function trade_withdraw()
    {
        return view('merchant.user.trade_withdraw');
    }

    //提现申请
    public function trade_withdraw_application(Request $request)
    {
        $id = $request->cookie('user_id',3);
        $account_balances = Merchant::where('merchant_id',$id)->value('account_balances');
        return view('merchant.user.trade_withdraw_application',['account_balances'=>$account_balances]);
    }

    //交易流水
    public function trade_bills()
    {
        return view('merchant.user.trade_bills');
    }

}
