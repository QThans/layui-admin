<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

return [
    /*
     * cdn resource address
     */
    'cdn_url'   => '/',
    /*
     * web title
     */
    'title'     => 'Layui Admin',
    'logo'      => 'LayuiAdmin - TP',
    'slogo'     => 'Admin',
    'dashboard' => [
        'title' => '控制台',
        'url'   => url('thans\layuiAdmin\controller\Index@dashboard'),
    ],
    'userMenu' => [
        [
            '个人设置',
            url('thans\layuiAdmin\controller\Personal@setting'),
        ],
        [
            '退出登录',
            '',
            ['target' => '_top', 'href' => url('thans\layuiAdmin\controller\Login@logout')],
        ],
    ],
    'login'     => [
        'logo'    => '<span>Layui Admin</span>',
        'title'   => '后台管理',
        's_title' => '登录',
        'copy'    => 'LayuiAdmin',
        'remeber' => true,
        'captcha' => '^.{4,6}$',//false不开启登录验证码，开启的话请添加验证正则
    ],
    'jump_tmpl' => app()->getRootPath().'vendor/thans/layui-admin/views/jump.html',

    'upload'   => [
        'image' => 'fileSize:1024000|fileExt:jpg,png,jpeg',
        'file'  => 'fileSize:1024000',
    ],
    'userMenu' => [
        [
            '个人设置',
            url('thans\layuiAdmin\controller\Personal@setting'),
        ],
        [
            '退出登录',
            '',
            ['target' => '_top', 'href' => url('thans\layuiAdmin\controller\Login@logout')],
        ],
    ],
];
