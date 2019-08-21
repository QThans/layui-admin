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
    'cdn_url' => '/',
    /*
     * web title
     */
    'title' => 'Layui Admin',
    'login' => [
        'logo'    => '<span>Layui Admin</span>',
        'title'   => '后台管理',
        's_title' => '登录',
        'copy'    => 'LyuiAdmin',
        'remeber' => true,
    ],
    'jump_tmpl' => app()->getRootPath().'vendor/thans/layui-admin/views/jump.html',

    'upload' => [
        'image' => 'filesize:1024000|fileExt:jpg,png,jpeg',
        'file'  => 'filesize:1024000',
    ],
];
