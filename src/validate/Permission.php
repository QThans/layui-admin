<?php


namespace thans\layuiAdmin\validate;


use think\Validate;

class Permission extends Validate
{
    protected $rule = [
        'name' => 'require|max:100',
        'http_method' => 'max:50',
        'path' => 'require',
        'alias' => ['require', 'max' => 100, 'regex' => '/^[a-zA-Z][a-zA-Z0-9_.-]+$/'],
    ];

    protected $message = [
        'name.require' => '菜单名称必须填写',
        'name.max' => '菜单名称最多不能超过25个字符',
        'http_method.max' => 'HTTP_Method不能超过100个字符',
        'alias' => '请输入正确的别名',
        'path' => '请输入HTTP地址',
    ];
}