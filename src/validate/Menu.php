<?php

namespace thans\layuiAdmin\validate;

use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'name'       => 'require|max:100',
        'parent_id'  => 'number',
        'weight'     => 'number|between:-32768,32768',
        'icon'       => 'max:100',
        'uri'        => 'max:200',
        'status'     => 'number',
        'permission' => 'max:200',
    ];

    protected $message = [
        'name'        => '菜单名称必须填写，且不超过25个字符',
        'parent_id'   => '非法上级菜单',
        'weight'      => '排序数字必须在-32768到32768之间',
        'icon'        => '非法ICON',
        'uri'         => 'URI不能超过100个字符',
        'status'      => '非法状态',
        'permission'  => '权限不能超过100个字符',
    ];
}
