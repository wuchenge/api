<?php

/**
 * 不需要登录
 */
Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {
    // 发送验证码
    Route::post('captcha', 'RegisterController@captcha')->name('api.register.captcha');
});

/**
 * 需要登录
 */
Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
    'middleware' => ['api.login', 'api']
], function () {
    // 发送验证码
    Route::post('index', 'LoginController@index')->name('api.login.index');
});
