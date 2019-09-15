<?php

namespace App\Admin\Controllers;

use App\Models\Dy\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DyUserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('用户列表')
            ->description('用户概要信息列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->paginate(10);
        $grid->filter(function ($filter) {
            $filter->like('nickname', 'nickname');
            $filter->in('gender')->checkbox([
                1 => 'Male',
                2 => 'Female',
            ]);
        });
        $grid->disableCreateButton();
        $grid->id('Id');
        $grid->short_id('Short id');
        $grid->unique_id('Unique id');
        $grid->nickname('Nickname');
        $grid->gender('Gender');

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
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->short_id('Short id');
        $show->unique_id('Unique id');
        $show->nickname('Nickname');
        $show->gender('Gender');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('short_id', 'Short id');
        $form->text('unique_id', 'Unique id');
        $form->text('nickname', 'Nickname');
        $form->switch('gender', 'Gender');

        return $form;
    }
}
