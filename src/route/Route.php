<?php

use think\facade\Route;

Route::group('admin', function () {
    Route::get('login', 'thans\layuiAdmin\controller\Login@index');
    Route::post('login', 'thans\layuiAdmin\controller\Login@doLogin');

    Route::group('', function () {
        Route::get('', 'thans\layuiAdmin\controller\Index@index');
        Route::group('personal', function () {
            Route::rule('setting',
                'thans\layuiAdmin\controller\Personal@setting', 'GET|POST');
        });
    })->middleware([
        thans\layuiAdmin\middleware\Login::class,
        [thans\layuiAdmin\middleware\AdminsAuth::class, false],
    ]);

    Route::group('', function () {
        Route::get('dashboard', 'thans\layuiAdmin\controller\Index@dashboard');
        Route::resource('menu', 'thans\layuiAdmin\controller\Menu');
        Route::resource('permission',
            'thans\layuiAdmin\controller\auth\Permission');
        Route::resource('role', 'thans\layuiAdmin\controller\auth\Role');
        Route::resource('auth/admins',
            'thans\layuiAdmin\controller\auth\Admins')->except(['delete']);
    })->middleware([
        thans\layuiAdmin\middleware\Login::class,
        thans\layuiAdmin\middleware\AdminsAuth::class,
    ]);

    Route::group('', function () {
        Route::get('logout', 'thans\layuiAdmin\controller\Login@logout');
        Route::post('upload/image', 'thans\layuiAdmin\controller\Upload@image');
        Route::post('upload/file', 'thans\layuiAdmin\controller\Upload@file');
    })->middleware([thans\layuiAdmin\middleware\Login::class]);

});
