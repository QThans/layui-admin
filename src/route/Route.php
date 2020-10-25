<?php

use think\facade\Config;
use think\facade\Route;

Route::group(Config::get('admin.urlPath'), function () {
    Route::group('', function () {
        Route::get('', 'thans\layuiAdmin\controller\Index@index')->name('layuiadmin_index');
        Route::group('personal', function () {
            Route::rule(
                'setting',
                'thans\layuiAdmin\controller\Personal@setting',
                'GET|POST'
            )->name('layuiadmin_person_setting');
        });
        Route::get('logout', 'thans\layuiAdmin\controller\Login@logout')->name('layuiadmin_logout');
        Route::post('upload/image', 'thans\layuiAdmin\controller\Upload@image');
        Route::post('upload/file', 'thans\layuiAdmin\controller\Upload@file');
    })->middleware([thans\layuiAdmin\middleware\Login::class]);

    Route::group('', function () {
        Route::get('dashboard', 'thans\layuiAdmin\controller\Index@dashboard')->name('layuiadmin_dashboard');
        Route::resource('menu', 'thans\layuiAdmin\controller\Menu')->name('layuiadmin_menu');
        Route::resource(
            'permission',
            'thans\layuiAdmin\controller\auth\Permission'
        )->name('layuiadmin_permission');
        Route::resource('role', 'thans\layuiAdmin\controller\auth\Role')->name('layuiadmin_role');
        Route::resource(
            'auth/admins',
            'thans\layuiAdmin\controller\auth\Admins'
        )->except(['delete'])->name('layuiadmin_admins');
    })->middleware([
        thans\layuiAdmin\middleware\Login::class,
        thans\layuiAdmin\middleware\AdminsAuth::class,
    ]);

    Route::group('system', function () {
        Route::resource('config_tab.config', 'thans\layuiAdmin\controller\system\Config')->name('layuiadmin_config_tab_config');
        Route::rule('config_tab/setting/:type/[:tab_id]', 'thans\layuiAdmin\controller\system\ConfigTab@setting')->name('layuiadmin_system_setting');
        Route::resource('config_tab', 'thans\layuiAdmin\controller\system\ConfigTab')->name('layuiadmin_config_tab');
    })->middleware([
        thans\layuiAdmin\middleware\Login::class,
        thans\layuiAdmin\middleware\AdminsAuth::class,
    ]);
});

Route::group(Config::get('admin.urlPath'), function () {
    Route::get('login', 'thans\layuiAdmin\controller\Login@index')->name('layuiadmin_login');
    Route::get('captcha', 'thans\layuiAdmin\controller\Login@captcha')->name('layuiadmin_captcha');
    Route::post('login', 'thans\layuiAdmin\controller\Login@doLogin')->name('layuiadmin_login_post');
});
