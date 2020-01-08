<?php

namespace thans\layuiAdmin\validate;

use think\Validate;

class SystemConfigTab extends Validate
{
    protected $rule = [
        'name'       => 'require|max:20',
        'alias'      => 'require|max:20',
        'status'     => 'number',
    ];

    protected $message = [
        'name'       => '配置名称必须填写，且不超过20个字符',
        'alias'      => '配置别名必须填写，且不超过20个字符',
        'status'     => '非法状态',
    ];
}
