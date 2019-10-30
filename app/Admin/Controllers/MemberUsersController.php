<?php

namespace App\Admin\Controllers;

use App\Admin\Export\MemberUsersExporter;
use App\Models\Admin\MemberUsers;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class MemberUsersController extends AdminController
{
    public $user = null;

    public function getUser()
    {
        if (empty($this->user)) {
            $this->user = Auth::guard('admin')->user();
        }

        return $this->user;
    }

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MemberUsers);
        $grid->exporter(new MemberUsersExporter());
        $grid->model()->where('admin_id', $this->getUser()->id)->orderBy('level', 'asc');
        $grid->column('no', __('admin.model.No'));
        $grid->column('name', __('admin.model.Name'));
        $grid->column('phone', __('admin.model.Phone'));
        $grid->column('level', __('admin.model.Level'));
        $grid->column('balance', __('admin.model.Balance'))
            ->display(function () {
                return sprintf("%.2f", bcdiv($this->balance, 100, 2));
            });
        $grid->column('points', __('admin.model.Points'));
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
        $show = new Show(MemberUsers::findOrFail($id));

        $show->field('no', __('admin.model.No'));
        $show->field('name', __('admin.model.Name'));
        $show->field('phone', __('admin.model.Phone'));
        $show->field('level', __('admin.model.Level'));
        $show->field('balance', __('admin.model.Balance'))
            ->as(function () {
                return sprintf("%.2f", bcdiv($this->balance, 100, 2));
            });
        $show->field('points', __('admin.model.Points'));
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
        $member = new MemberUsers;
        $member->admin_id = $this->getUser()->id;
        $member->no = $member->admin_id * 1000000 + $this->getMaxNo();

        $form = new Form($member);
        $form->text('name', __('admin.model.Name'));
        $form->mobile('phone', __('admin.model.Phone'));
        $form->number('level', __('admin.model.Level'))->default(1);
        $form->number('balance', __('admin.model.Balance'))->default(0);
        $form->number('points', __('admin.model.Points'))->default(0);
        $form->saving(function (Form $form) {
            $form->balance = intval($form->balance * 100);
        });
        return $form;
    }

    public function getMaxNo()
    {
        $no = MemberUsers::query()
            ->where('admin_id', $this->getUser()->id)
            ->max('no');
        return empty($no) ? 1 : (intval($no) % 1000000) + 1;
    }
}
