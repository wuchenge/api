<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');

    // 错误消息
    $router->resource('errors', 'ErrorsController');

    // 文章
    $router->resource('articles', 'ArticlesController');

    // 版本管理
    $router->resource('versions', 'VersionsController');
});
