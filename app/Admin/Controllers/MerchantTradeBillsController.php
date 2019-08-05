<?php

namespace App\Admin\Controllers;

use App\Models\MerchantTradeBills;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MerchantTradeBillsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\MerchantTradeBills';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MerchantTradeBills);

        $grid->column('total_bill_id', __('Total bill id'));
        $grid->column('merchant_id', __('Merchant id'));
        $grid->column('bill_type', __('Bill type'));
        $grid->column('status', __('Status'));
        $grid->column('amount', __('Amount'));
        $grid->column('charges_amount', __('Charges amount'));
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
        $show = new Show(MerchantTradeBills::findOrFail($id));

        $show->field('total_bill_id', __('Total bill id'));
        $show->field('merchant_id', __('Merchant id'));
        $show->field('bill_type', __('Bill type'));
        $show->field('status', __('Status'));
        $show->field('amount', __('Amount'));
        $show->field('charges_amount', __('Charges amount'));
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
        $form = new Form(new MerchantTradeBills);

        $form->number('total_bill_id', __('Total bill id'));
        $form->number('merchant_id', __('Merchant id'));
        $form->text('bill_type', __('Bill type'));
        $form->switch('status', __('Status'))->default(1);
        $form->decimal('amount', __('Amount'))->default(0.00);
        $form->decimal('charges_amount', __('Charges amount'))->default(0.00);

        return $form;
    }
}
