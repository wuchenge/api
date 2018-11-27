<?php

Route::get('/', function () {
    // phpinfo();
    // for ($i=0; $i < 10; $i++) {
    //     logger('logger log' . $i);
    // }
    clock('clock log');
    \DB::enableQueryLog();
    $user = App\Models\User::all();

    return response()->json(\DB::getQueryLog());
});
