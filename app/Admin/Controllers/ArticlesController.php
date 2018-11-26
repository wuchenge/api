<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ArticlesController extends Controller
{
    use HasResourceActions;

    protected $title;
    protected $states;

    public function __construct()
    {
        $this->title = '文章';
        $this->states = [
            'on'  => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => '隐藏', 'color' => 'default'],
        ];
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('description')
            ->body($this->grid());
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
            ->header($this->title)
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
            ->header($this->title)
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
        $grid = new Grid(new Article);

        // 禁用创建按钮
        // $grid->disableCreateButton();
        // 禁用分页条
        // $grid->disablePagination();
        // 禁用查询过滤器
        // $grid->disableFilter();
        // 禁用导出数据
        $grid->disableExport();
        // 禁用行选择checkbox
        $grid->disableRowSelector();
        // 禁用行操作列
        // $grid->disableActions();

        $grid->actions(function ($actions) {
            // $actions->disableDelete();
            // $actions->disableEdit();
            $actions->disableView();
        });

        $grid->disableExport();
        $grid->disableRowSelector();

        // $grid->id('Id');
        $grid->title('标题');
        // $grid->content('Content');
        $grid->type('类型')->display(function ($val) {
            return Article::$typeMap[$val];
        });

        $grid->status('状态')->switch($this->states);
        $grid->created_at('添加时间');
        $grid->updated_at('修改时间');

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);

        $language  = config('language');

        $form->text('title', '标题')->rules('required|max:100');
        $form->select('language', '语种')->options($language)->default('zh_CN');
        $form->text('alias', '别名')->help('可不填写');
        $form->editor('content', '内容')->rules('required');
        $form->select('type', '类型')->options(Article::$typeMap)->default(Article::TYPE_AGREEMENT);
        $form->switch('status', '状态')->states($this->states)->default(Article::STATUS_YES);

        $form->saving(function (Form $form) {
            if (!$form->alias) {
                $form->alias = app('translug')->translate($form->title);
            }
        });

        $form->saved(function (Form $form) {
            // $product = $form->model();
            // $this->dispatch(new SyncOneProductToES($product));
        });

        return $form;
    }
}
