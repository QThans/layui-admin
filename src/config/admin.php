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
    /**
     * web title
     */
    'title' => 'Inge Admin',
    'login' => [
        'logo' => '<span>Inge Admin</span>',
        'title' => '后台管理',
        's_title' => '登录',
        'copy' => '版权所有',
        'remeber' => true,
    ],
    'jump_tmpl' => Env::get('root_path') . 'vendor/thans/layui-admin/views/jump.html',

    'upload' => [
        'image' => [
            'size' => 1024000,//KB
            'ext' => 'jpg,png,jpeg'
        ],
        'file' => [
            'size' => 1024000,//KB
            'ext' => '*'
        ]
    ]
];
