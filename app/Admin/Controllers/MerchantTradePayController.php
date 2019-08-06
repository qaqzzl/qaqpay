<?php

namespace App\Admin\Controllers;

use App\Models\MerchantTradePay;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MerchantTradePayController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\MerchantTradePay';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MerchantTradePay);

        $grid->column('pay_id', __('Pay id'));
        $grid->column('merchant_id', __('Merchant id'));
        $grid->column('trade_no', __('Trade no'));
        $grid->column('status', __('Status'));
        $grid->column('out_pay_status', __('Out pay status'));
        $grid->column('out_trade_no', __('Out trade no'));
        $grid->column('out_gmt_payment', __('Out gmt payment'));
        $grid->column('merchant_trade_no', __('Merchant trade no'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('subject', __('Subject'));
        $grid->column('body', __('Body'));
        $grid->column('timeout_express', __('Timeout express'));
        $grid->column('passback_params', __('Passback params'));
        $grid->column('notify_url', __('Notify url'));
        $grid->column('choose_pay_type', __('Choose pay type'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(MerchantTradePay::findOrFail($id));

        $show->field('pay_id', __('Pay id'));
        $show->field('merchant_id', __('Merchant id'));
        $show->field('trade_no', __('Trade no'));
        $show->field('status', __('Status'));
        $show->field('out_pay_status', __('Out pay status'));
        $show->field('out_trade_no', __('Out trade no'));
        $show->field('out_gmt_payment', __('Out gmt payment'));
        $show->field('merchant_trade_no', __('Merchant trade no'));
        $show->field('total_amount', __('Total amount'));
        $show->field('subject', __('Subject'));
        $show->field('body', __('Body'));
        $show->field('timeout_express', __('Timeout express'));
        $show->field('passback_params', __('Passback params'));
        $show->field('notify_url', __('Notify url'));
        $show->field('choose_pay_type', __('Choose pay type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MerchantTradePay);

        $form->number('merchant_id', __('Merchant id'));
        $form->text('trade_no', __('Trade no'));
        $form->text('status', __('Status'));
        $form->switch('out_pay_status', __('Out pay status'))->default(1);
        $form->text('out_trade_no', __('Out trade no'));
        $form->number('out_gmt_payment', __('Out gmt payment'));
        $form->text('merchant_trade_no', __('Merchant trade no'));
        $form->decimal('total_amount', __('Total amount'));
        $form->text('subject', __('Subject'));
        $form->text('body', __('Body'));
        $form->text('timeout_express', __('Timeout express'))->default('1d');
        $form->text('passback_params', __('Passback params'));
        $form->text('notify_url', __('Notify url'));
        $form->text('choose_pay_type', __('Choose pay type'));

        return $form;
    }
}
