<?php

namespace App\Admin\Controllers;

use App\Models\Merchant;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Ramsey\Uuid\Uuid;

class MerchantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Merchant);

        $grid->column('merchant_id', __('ID'));
        $grid->column('name', __('商户名称'));
        $grid->column('account', __('账号'));
        $grid->column('secret_key', __('秘钥'));
        $grid->column('phone', __('手机号'));
        $grid->column('email', __('邮箱'));
        $grid->column('total_trade_amount', __('商户总交易金额'));
        $grid->column('total_server_income', __('获取收益'));
        $grid->column('created_at', __('加入时间'))->display(function ($name) {
            return date('Y-m-d',$name);
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
        $show = new Show(Merchant::findOrFail($id));

        $show->field('merchant_id', __('ID'));
        $show->field('account', __('账号'));
        $show->field('secret_key', __('秘钥'));
        $show->field('name', __('昵称'));
        $show->field('phone', __('手机号'));
        $show->field('email', __('邮箱'));
        $show->field('total_server_income', __('系统收益总收益'));
        $show->field('total_trade_amount', __('商户总交易金额'));
        $show->field('account_balances', __('商户余额'));
        $show->field('charges_percentage', __('商户交易手续费百分比'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Merchant);
        $form->text('name', __('商家名称'));
        $form->text('account', __('账号'));
        $form->password('password', __('密码'))->value('');
        $form->mobile('phone', __('手机号'));
        $form->email('email', __('邮箱'));
        $form->decimal('charges_percentage', __('交易手续费'))->default(0.00);
        $form->text('secret_key')->value(Uuid::uuid4())->readonly();

        //保存前回调
        $form->saving(function (Form $form) {
            //$form->secret_key = '132';
        });

        return $form;
    }
}
