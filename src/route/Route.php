<?php

use think\facade\Route;

Route::group('admin', function () {
    Route::get('', 'thans\layuiAdmin\controller\Index@index');
    Route::get('login', 'thans\layuiAdmin\controller\Login@index');
    Route::post('login', 'thans\layuiAdmin\controller\Login@doLogin');
    Route::resource('menu', 'thans\layuiAdmin\controller\Menu');
});
