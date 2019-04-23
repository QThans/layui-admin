<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Load;

class Form
{
    use Load;

    public $tmpl = 'form';

    public $url = '';

    public $id = '';

    public $method = 'post';

    public $data = [];

    public $dataUrl = '';

    public $dataMethod = 'get';

    public $rules = [];

    public $submitBtn = "保存";

    public $field = [];

    public $hiddenSubmit = false;

    public $setValueScript = [];

    //请求成功状态码
    public $successStatusCode = 0;

    //请求成功后脚本  null 或  continue 或 msg
    public $successEndScript = 'continue';

    //提交前脚本
    public $submitStartSctipt = [];

    //提交结束后脚本
    public $submitEndSctipt = [];

    public $classMap = [
        'input' => form\Input::class,
        'text' => form\Text::class,
        'textarea' => form\Textarea::class,
        'number' => form\Number::class,
        'select' => form\Select::class,
        'multiSelect' => form\MultiSelect::class,
        'onoff' => form\Onoff::class,
        'checkbox' => form\Checkbox::class,
        'authtree' => form\Authtree::class,
        'richtext' => form\Richtext::class,
        'upload' => form\Upload::class,
        'icon' => form\Icon::class,
    ];

    public $formVerify = [
        'account' => [
            'reg' => '/^[\S]{5,24}$/',
            'tips' => '用户名必须5到50位，且不能出现空格'
        ],
        'password' => [
            'reg' => '/^[\S]{6,24}$/',
            'tips' => '密码必须6到24位，且不能出现空格'
        ],
        'phone' => [
            'reg' => '/^1\d{10}$/',
            'tips' => '请输入正确的手机号'
        ],
        'email' => [
            'reg' => '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
            'tips' => '请输入正确的手机号'
        ],
        'required' => [
            'reg' => '/[\S]+/',
            'tips' => '必填项不能为空'
        ],
        'url' => [
            'reg' => '/(^#)|(^http(s*):\/\/[^\s]+\.[^\s]+)/',
            'tips' => '网址格式不正确'
        ],
        'date' => [
            'reg' => '/^(\d{4})[-\/](\d{1}|0\d{1}|1[0-2])([-\/](\d{1}|0\d{1}|[1-2][0-9]|3[0-1]))*$/',
            'tips' => '日期格式不正确'
        ],
        'number' => [
            'reg' => '/^[0-9]+.?[0-9]*$/',
            'tips' => '请输入数字'
        ],
        'identity' => [
            'reg' => '/(^\d{15}$)|(^\d{17}(x|X|\d)$)/',
            'tips' => '请输入正确的身份证号'
        ]
    ];

    public function init()
    {
        $this->id = uniqid();
        $this->builder->module('form');
        $this->builder->module('jquery');
    }

    final public function setValueScript($key, $value)
    {
        $this->setValueScript[$key] = $value;
    }

    final public function submitStartSctipt($key, $value)
    {
        $this->submitStartSctipt[$key] = $value;
    }

    final public function submitEndSctipt($key, $value)
    {
        $this->submitEndSctipt[$key] = $value;
    }

    public function data($data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function end()
    {
        $code = $this->display(__DIR__ . DIRECTORY_SEPARATOR . 'form' . DIRECTORY_SEPARATOR . 'stub' . DIRECTORY_SEPARATOR . 'form.js.stub');
        $this->builder->script('form', $code);
    }

    public function getFields()
    {
        return implode('', $this->filed);
    }
}
