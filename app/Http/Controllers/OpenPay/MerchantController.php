<?php

namespace App\Http\Controllers\OpenPay;

use App\Models\Merchant;
use App\Models\MerchantAmountWithdraw;
use App\Models\MerchantTradeBills;
use App\Models\MerchantTradePay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class MerchantController extends BaseController
{
    //登录
    public function signin(Request $request)
    {
        $Merchant = Merchant::where('account',$request->account)->first();
        if ($Merchant->password != md5($request->password)) {
            return api_error(20002);
        }
        $access_token = Uuid::uuid4()->toString();
        $Merchant->access_token = $access_token;
        $Merchant->save();
        return api_success(['access_token'=>$access_token,'id'=>$Merchant->merchant_id]);
    }

    //商户账号信息
    public function merchantInfo(Request $request)
    {
        $id = $request->input('user_id');
        $info = Merchant::where('merchant_id',$id)->select('account','name','email','secret_key','created_at')->first();
        return api_success($info);
    }

    /**
     * 修改资料
    */
    public function merchantInfoUpdate(Request $request)
    {
        $this->validate($request,[
            'password'=>'required',
            'secret_key'=>'required',
            'name'=>'required',
            'email'=>'required',
        ]);
        $id = $request->get('user_id');
        $Merchant = Merchant::where('merchant_id',$id)->first();

        if ($Merchant->password != md5($request->password)) return api_error(20004);

        $Merchant->password = $request->password;
        $Merchant->secret_key = $request->secret_key;
        $Merchant->name = $request->name;
        $Merchant->email = $request->email;
        if ($Merchant->save()) {
            return api_success();
        } else {
            return api_error(5000);
        }
    }

    //提现申请
    public function tradeWithdrawApplication(Request $request)
    {
        $this->validate($request,[
            'amount'=>'required',
            'number'=>'required',
        ]);
        DB::beginTransaction();    //主事务
        try {
            $Merchant = Merchant::find($request->user_id);
            if ($Merchant->account_balances < $request->amount) return api_error(20003);
            //扣除余额
            $Merchant->account_balances -= $request->amount;
            $Merchant->save();
            //创建交易流水表
            if (!$bills = MerchantTradeBills::create([
                'merchant_id'=>$request->user_id,
                'bill_type'=>'withdraw',
                'status'=>1,
                'amount'=>$request->amount,
            ])) {
                DB::rollBack();
                return api_error(5000);
            }
            //创建提现申请
            if (!MerchantAmountWithdraw::create([
                'bills_id'=>$bills->bills_id,
                'merchant_id'=>$request->user_id,
                'amount'=>$request->amount,
                'number'=>$request->number,
                'status'=>'wait',
                'merchant_remarks'=>$request->input('merchant_remarks'),
            ])) {
                DB::rollBack();
                return api_error(5000);
            }
            DB::commit();
            return api_success();
        }catch (\Exception $exception) {
            DB::rollBack();
            return api_error(5000,$exception->getMessage());
        }


    }

    //提现列表
    public function tradeWithdrawList(Request $request)
    {
        $limit = $request->input('limit',10);
        $AmountWithdraw = MerchantAmountWithdraw::where('merchant_id',$request->user_id)->orderBy('withdraw_id','desc');
        $info = $AmountWithdraw->paginate($limit);
        $info = $info->toArray();
        foreach ($info['data'] as &$vo) {
            $vo['created_at'] = date('Y-m-d H:i:s',$vo['created_at']);
            $vo['operating_time'] = date('Y-m-d H:i:s',$vo['operating_time']);
        }
        return api_success($info);
    }

    //交易流水列表
    public function tradeBillsList(Request $request)
    {
        $limit = $request->input('limit',10);
        $TradeBills = MerchantTradeBills::where('merchant_id',$request->user_id)->orderBy('bills_id','desc');
        $info = $TradeBills->paginate($limit);
        $info = $info->toArray();
        foreach ($info['data'] as &$vo) {
            $vo['created_at'] = date('Y-m-d H:i:s',$vo['created_at']);
        }
        return api_success($info);
    }

    //交易统计
    public function tradeStatistics(Request $request)
    {
        $merchant_id = $request->user_id;
        //今日交易金额
        $info['today_total_amount'] = MerchantTradePay::where('created_at','>',strtotime(date('Y-m-d',time())) )
            ->where('merchant_id',$merchant_id)
            ->where(['out_pay_status'=>0])->sum('total_amount');

        //今日到账金额
        $info['today_arrival_amount'] = MerchantTradeBills::where('created_at','>',strtotime(date('Y-m-d',time())) )
            ->where('bill_type','openpay')
            ->where('merchant_id',$merchant_id)->sum('amount');

        //已提现金额
        $info['total_withdraw_amount'] = MerchantTradeBills::where('bill_type','withdraw')
            ->where('status',0)
            ->where('merchant_id',$merchant_id)->sum('amount');

        //提现中金额
        $info['total_withdraw_wait_amount'] = MerchantTradeBills::where('bill_type','withdraw')
            ->where('status',1)
            ->where('merchant_id',$merchant_id)->sum('amount');

        //交易总金额
        $info['total_trade_amount'] = Merchant::where('merchant_id',$merchant_id)->value('total_trade_amount');

        //账户余额
        $info['account_balances'] = Merchant::where('merchant_id',$merchant_id)->value('account_balances');

        return api_success(['info'=>$info]);
    }
}
