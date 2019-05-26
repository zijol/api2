<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/31
 * Time: 13:50
 */

namespace App\Admin\Controllers;

use App\Admin\Widgets\MdToHtml;
use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Widgets\Box;
use Zijol\Model\Admin\DocMarkdownModel;

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
     */
    public function store(Request $request)
    {
        (new DocMarkdownModel($request->toArray()))->save();
    }

    /**
     * update interface
     *
     * @param $id
     * @param Request $request
     */
    public function update($id, Request $request)
    {
        DocMarkdownModel::query()->updateOrCreate([
            'id' => $id
        ], $request->toArray());
    }

    /**
     * Destroy interface
     *
     * @param $id
     */
    public function destroy($id)
    {
        DocMarkdownModel::findOrFail($id)->delete();
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

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('title', 'Title');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Box
     */
    protected function detail($id)
    {
        $doc = DocMarkdownModel::findOrFail($id);
        $htmlContent = (new \Parsedown())->parse($doc->content);
        $box = new Box($doc->title, new MdToHtml($htmlContent));
        $box->removable();
        $box->collapsable();
        $box->solid();
//        $box->style('info');
        $box->solid();

        return $box;
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
