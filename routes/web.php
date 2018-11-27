<?php

Route::get('/', function () {
    // phpinfo();
     for ($i=0; $i < 10; $i++) {
         logger('logger log' . $i);
     }
     $a=1;
     $b=2;
     $c=&$b;
     $c=3;
     $d=$a*$c;
    clock('clock log');
    \DB::enableQueryLog();
    $user = App\Models\User::all();

    return response()->json(\DB::getQueryLog());
});
