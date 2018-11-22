<?php

/**
 * 不需要登录
 */
Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
    'middleware' => [
        'api',
        'throttle:60,1'
    ]
], function () {
    // 发送验证码
    Route::post('captcha', 'RegisterController@captcha')->name('api.register.captcha');
    // 注册
    Route::post('register', 'RegisterController@index')->name('api.register.index');
    // 登录
    Route::post('login', 'LoginController@index')->name('api.login.index');
});

/**
 * 需要登录
 */
Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
    'middleware' => [
        'api.login',
        'api',
        'throttle:60,1'
    ]
], function () {
    // 刷新验证码
    Route::post('refresh', 'LoginController@refresh')->name('api.login.refresh');
});
