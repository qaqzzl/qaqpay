<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\MerchantAmountWithdraw\Withdraw;
use App\Models\MerchantAmountWithdraw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MerchantAmountWithdrawController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '提现管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MerchantAmountWithdraw);

        //禁用创建按钮
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->add(new Withdraw);        //提现操作

            // 去掉删除
            $actions->disableDelete();

            // 去掉编辑
            $actions->disableEdit();

            // 去掉查看
            $actions->disableView();
        });

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();    //去除批量删除
        });

        $grid->column('withdraw_id', __('ID'));
//        $grid->column('bills_id', __('Bills id'));
        $grid->column('merchant.name', __('商户名称'));
        $grid->column('status', __('提现状态'));
        $grid->column('amount', __('提现金额'));
        $grid->column('number', __('提现账号'));
        $grid->column('merchant_remarks', __('提现商户备注'));
        $grid->column('operating_time', __('操作时间'));
        $grid->column('operating_remarks', __('操作备注'));
        $grid->column('created_at', __('创建时间'))->display(function ($value) {
            return date('Y-m-d H:i:s',$value);
        });
        $grid->column('updated_at', __('更新时间'))->display(function ($value) {
            return date('Y-m-d H:i:s',$value);
        });


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
        $show = new Show(MerchantAmountWithdraw::findOrFail($id));

        $show->field('withdraw_id', __('Withdraw id'));
        $show->field('bills_id', __('Bills id'));
        $show->field('merchant_id', __('Merchant id'));
        $show->field('status', __('Status'));
        $show->field('amount', __('Amount'));
        $show->field('number', __('Number'));
        $show->field('merchant_remarks', __('Merchant remarks'));
        $show->field('operating_time', __('Operating time'));
        $show->field('operating_remarks', __('Operating remarks'));
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
        $form = new Form(new MerchantAmountWithdraw);

        $form->number('bills_id', __('Bills id'));
        $form->number('merchant_id', __('Merchant id'));
        $form->text('status', __('Status'))->default('1');
        $form->decimal('amount', __('Amount'))->default(0.00);
        $form->text('number', __('Number'))->default('0.00');
        $form->text('merchant_remarks', __('Merchant remarks'));
        $form->number('operating_time', __('Operating time'));
        $form->text('operating_remarks', __('Operating remarks'));

        return $form;
    }
}
