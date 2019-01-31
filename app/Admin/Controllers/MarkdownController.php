<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/31
 * Time: 13:50
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Model\DocMarkdownModel;
use Illuminate\Http\Request;
use Encore\Admin\Form;

class MarkdownController extends Controller
{
    protected $classify = [
        'user' => '用户',
        'strategy' => '策略',
    ];

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
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
     * Save interface
     *
     * @param Request $request
     * @return bool
     */
    public function store(Request $request)
    {
        (new DocMarkdownModel($request->toArray()))->save();
        return back()->with(compact('success'));
    }

    /**
     * Destroy interface
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        DocMarkdownModel::findOrFail($id)->delete();
        return back()->with(compact('success'));
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
        $classify = $this->classify;
        $grid = new Grid(new DocMarkdownModel);

        $grid->model()->orderBy('classify', 'asc');

        $grid->classify('Classify')->display(function ($title) use ($classify) {
            return $classify[$title] ?? "未知";
        })->sortable();
        $grid->title('Title');
        $grid->description('Description');

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
        $show = new Show(DocMarkdownModel::findOrFail($id));

        $show->title('ID');
        $show->classify('Classify');
        $show->content('Content');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DocMarkdownModel);

        $form->select('classify', 'Classify')->options($this->classify);
        $form->text('title', 'Title');
        $form->text('description', 'Description');
        $form->simplemde('content')->height(500);

        return $form;
    }


}
