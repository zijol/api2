<?php

namespace App\Admin\Controllers;

use App\Models\Admin\MemberCouponTemplate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MemberCouponTemplateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券模板';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MemberCouponTemplate);

        $grid->column('type', __('admin.model.Type'))
            ->display(function () {
                return MemberCouponTemplate::TYPE_LIST[$this->type] ?? "未知";
            });
        $grid->column('name', __('admin.model.Name'));
        $grid->column('amount', __('admin.model.Amount') . '(元)')
            ->display(function () {
                return fen_to_yuan($this->amount);
            });
        $grid->column('discount', __('admin.model.Discount'))
            ->display(function () {
                return to_discount($this->discount);
            });
        $grid->column('attain_amount', __('admin.model.AttainAmount') . '(元)')
            ->display(function () {
                return fen_to_yuan($this->attain_amount);
            });
        $grid->column('discount_amount', __('admin.model.DiscountAmount') . '(元)')
            ->display(function () {
                return fen_to_yuan($this->discount_amount);
            });
        $grid->column('expire', __('admin.model.Expire') . '(天)')
            ->display(function () {
                return sprintf("%.2f", bcdiv($this->expire, 86400, 2));
            });
        $grid->column('created_at', __('admin.model.CreatedAt'));
        $grid->column('updated_at', __('admin.model.UpdatedAt'));

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
        $show = new Show(MemberCouponTemplate::findOrFail($id));

        $show->field('type', __('admin.model.Type'))
            ->as(function () {
                return MemberCouponTemplate::TYPE_LIST[$this->type] ?? "未知";
            });
        $show->field('name', __('admin.model.Name'));
        $show->field('amount', __('admin.model.Amount') . '(元)')
            ->as(function () {
                return fen_to_yuan($this->amount);
            });
        $show->field('discount', __('admin.model.Discount'));
        $show->field('attain_amount', __('admin.model.AttainAmount') . '(元)')
            ->as(function () {
                return fen_to_yuan($this->attain_amount);
            });
        $show->field('discount_amount', __('admin.model.DiscountAmount') . '(元)')
            ->as(function () {
                return fen_to_yuan($this->discount_amount);
            });
        $show->field('expire', __('admin.model.Expire') . "(天)")
            ->as(function () {
                return sprintf("%.2f", bcdiv($this->expire, 86400, 2));
            });
        $show->field('created_at', __('admin.model.CreatedAt'));
        $show->field('updated_at', __('admin.model.UpdatedAt'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MemberCouponTemplate);

        $form->select('type', __('admin.model.Type'))
            ->options(MemberCouponTemplate::TYPE_LIST);
        $form->text('name', __('admin.model.Name'))->required();
        $form->number('amount', __('admin.model.Amount') . '(元)')->default(0);
        $form->number('discount', __('admin.model.Discount'))->max(10)->default(0);
        $form->number('attain_amount', __('admin.model.AttainAmount') . '(元)')->default(0);
        $form->number('discount_amount', __('admin.model.DiscountAmount') . '(元)')->default(0);
        $form->number('expire', __('admin.model.Expire') . '(天)')->default(0);
        $form->saving(function (Form $form) {
            $form->amount = yuan_to_fen($form->amount);
            $form->attain_amount = yuan_to_fen($form->attain_amount);
            $form->discount_amount = yuan_to_fen($form->discount_amount);
            $form->expire = intval($form->expire * 86400);
            $form->discount = intval($form->discount * 10);
        });
        return $form;
    }
}
