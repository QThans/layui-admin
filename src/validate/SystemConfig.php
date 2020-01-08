<?php

namespace thans\layuiAdmin\validate;

use think\Validate;

class SystemConfig extends Validate
{
    protected $rule = [
        'name'       => 'require|max:100',
        'alias'      => 'require|max:100',
        'type'       => 'require',
        'tips'       => 'max:255',
        'rules'      => 'max:255',
        'weight'     => 'number|between:-100000,100000',
    ];

    protected $message = [
        'name'      => '配置项名称必须填写，且不超过100个字符',
        'alias'     => '配置项别名必须填写，且不超过100个字符',
        'type'      => '配置类型不能为空',
        'tips'      => '提示不得超过255个字符',
        'rules'     => '规则不得超过255个字符',
        'weight'    => '请输入合法的排序数值',
    ];
}
