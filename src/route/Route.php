<?php

use think\facade\Route;

Route::group('admin', function () {
    Route::get('login', 'thans\layuiAdmin\controller\Login@index');
    Route::post('login', 'thans\layuiAdmin\controller\Login@doLogin');
    Route::group('', function () {
        Route::get('', 'thans\layuiAdmin\controller\Index@index');
        Route::resource('menu', 'thans\layuiAdmin\controller\Menu');
        Route::resource('permission', 'thans\layuiAdmin\controller\auth\Permission');
    })->middleware([thans\layuiAdmin\middleware\Login::class, thans\layuiAdmin\middleware\Auth::class]);
});
