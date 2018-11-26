<?php

namespace App\Admin\Controllers;

use App\Models\Error;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ErrorsController extends Controller
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
            ->header('返回消息')
            ->description('description')
            ->body($this->grid());
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
            ->header('添加')
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
        $language  = config('language');
        $grid = new Grid(new Error);

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
        $grid->disableActions();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        // $grid->id('Id');
        $grid->error_code('消息码')->editable();
        $grid->language('语言')->display(function ($v) use ($language) {
            return $language[$v];
        });
        $grid->content('返回消息')->editable();
        $grid->filter(function ($filter) use ($language) {
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $query->where('error_code', 'like', "%{$this->input}%");
            }, '消息码');
            $filter->equal('language', '语种')->select($language);
            $filter->where(function ($query) {
                $query->where('content', 'like', "%{$this->input}%");
            }, '消息');
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $language  = config('language');
        $form = new Form(new Error);

        $form->number('error_code', '消息码')->rules('required|regex:/^\d+$/', [
                'regex' => 'error_code必须全部为数字',
                'required' => 'error_code必须'
            ]);
        $form->select('language', '语种')->options($language)->default('zh_CN');
        $form->textarea('content', '消息')->rules('required|max:200', [
            'required' => '消息必须',
            'max' => '最多200个字'
        ]);

        return $form;
    }
}
