<?php


namespace thans\layuiAdmin\validate;


use think\Validate;

class AuthRole extends Validate
{
    protected $rule = [
        'name|权限组名称' => 'require|max:100|min:2',
        'alias|权限组别名' => 'require|min:2|max:20',
    ];
}