<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-26 15:45:50
 */

namespace App\Admin\Controllers;

use App\Models\Version;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use zgldh\QiniuStorage\QiniuStorage;
use Illuminate\Http\Request;

class VersionsController extends Controller
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
        $version = Version::find($id);
        $languages = config('language');

        $disk = QiniuStorage::disk('qiniu');
        $qiniu_token = $disk->uploadToken();
        return $content
            ->header('编辑')
            ->description('版本')
            ->body(view('admin.version.create_and_edit', compact('version', 'languages', 'qiniu_token')));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        $version = new Version();
        $languages = config('language');

        $disk = QiniuStorage::disk('qiniu');
        $qiniu_token = $disk->uploadToken();
        return $content
            ->header('添加')
            ->description('版本')
            ->body(view('admin.version.create_and_edit', compact('version', 'languages', 'qiniu_token')));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Version);
        $language  = config('language');
        $grid->disableRowSelector();
        $grid->id('Id');
        $grid->type('平台')->display(function ($v) {
            return Version::$typeMap[$v];
        });
        $grid->version('版本号');
        $grid->status('是否强制更新')->display(function ($v) {
            return Version::$statusMap[$v];
        });
        $grid->url('下载地址');
        $grid->intro('更新说明');
        $grid->language('语言')->display(function ($l) use ($language) {
            return $language[$l];
        });
        $grid->created_at('添加时间');
        $grid->updated_at('更新时间');

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

    public function store(Request $request)
    {
        $res = Version::create($request->all());
        if ($res) {
            return response()->json([
                'status'  => true,
                'message' => '成功',
            ]);
        }
        return response()->json([
            'status'  => false,
            'message' => '成功',
        ]);
    }

    public function update(Request $request, Version $version)
    {
        $res = $version->update($request->all());
        if ($res) {
            return response()->json([
                'status'  => true,
                'message' => '成功',
            ]);
        }
        return response()->json([
            'status'  => false,
            'message' => '成功',
        ]);
    }
}
