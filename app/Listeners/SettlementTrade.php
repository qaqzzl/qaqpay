<?php

namespace App\Listeners;

use App\Events\TradePaySuccess;
use App\Models\MerchantTradeBills;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SettlementTrade
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TradePaySuccess  $event
     * @return void
     */
    public function handle(TradePaySuccess $event)
    {
        $MerchantTradePay = $event->MerchantTradePay;
        $charges_amount = $MerchantTradePay->total_amount * $MerchantTradePay->merchant->charges_percentage / 100;
        $bill = MerchantTradeBills::create([
            'merchant_id'=>$MerchantTradePay->merchant_id,
            'bill_type'=>'openpay',
            'status'=>0,
            'amount'=>$MerchantTradePay->total_amount - $charges_amount,
            'charges_amount'=>$charges_amount,
            'out_trade_no'=>$MerchantTradePay->out_trade_no,
        ]);
        $MerchantTradePay->status = 'end';  //已结算
        $MerchantTradePay->save();
        $merchant = $MerchantTradePay->merchant;
        $merchant->total_trade_amount += $MerchantTradePay->total_amount;
        $merchant->account_balances += $bill->amount;
        $merchant->total_server_income += $bill->charges_amount;
        $merchant->save();
    }
}
