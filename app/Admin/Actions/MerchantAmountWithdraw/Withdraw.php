<?php

namespace App\Admin\Actions\MerchantAmountWithdraw;

use App\Models\Merchant;
use App\Models\MerchantTradeBills;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Withdraw extends RowAction
{
    public $name = '提现操作';

    public function form(Model $model)
    {
        $type = [
            'failure' => '拒绝',
            'success' => '同意',
        ];
        $this->text('商户名称','商户名称')->disable()->value($model->merchant->name);
        $this->text('商户名称','商户提现账号')->disable()->value($model->number);
        $this->text('商户名称','商户提现金额')->disable()->value($model->amount);
        $this->textarea('商户名称','商户提现备注')->disable()->value($model->merchant_remarks);
        $this->radio('status', '状态')->options($type)->rules('required');
        $this->textarea('operating_remarks', '提现备注')->rules('required');
    }

    public function handle(Model $model,Request $request)
    {
        $model->status = $request->get('status');
        $model->operating_remarks = $request->get('operating_remarks');
        $model->operating_time = time();
        DB::beginTransaction();
        if ($request->get('status') == 'success') {
            //更新商户流水表
            MerchantTradeBills::where('bills_id',$model->bills_id)->update(['status'=>0]);
        } else if ($request->get('status') == 'failure'){
            //更新商户流水表
            MerchantTradeBills::where('bills_id',$model->bills_id)->update(['status'=>2]);
            //更新账户余额表
            Merchant::where('merchant_id',$model->merchant_id)->increment('account_balances',$model->amount);
        }
        if ($model->save()) {
            DB::commit();
            return $this->response()->success('Success message.')->refresh();
        }
        DB::rollBack();
        return $this->response()->error('操作失败.')->refresh();
    }

}