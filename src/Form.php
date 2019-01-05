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

class Form extends Builder
{
    use Load;

    public $tmpl = 'form';

    public $url = '';

    public $id = '';

    public $method = 'post';

    public $dataUrl = '';

    public $dataMethod = 'get';

    public $rules = [];

    public $classMap = [
        'input' => Form\Input::class,
        'text' => Form\Text::class,
        'number' => Form\Number::class,
        'select' => Form\Select::class,
        'onoff' => Form\Onoff::class,
    ];

    public $formVerify = [
        'account'=>[
            'reg'=>'/^[\S]{5,24}$/',
            'tips'=>'用户名必须5到50位，且不能出现空格'
        ],
        'password'=>[
            'reg'=>'/^[\S]{6,24}$/',
            'tips'=>'密码必须6到24位，且不能出现空格'
        ],
        'phone'=>[
            'reg'=>'/^1\d{10}$/',
            'tips'=>'请输入正确的手机号'
        ],
        'email'=>[
            'reg'=>'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
            'tips'=>'请输入正确的手机号'
        ],
        'required'=>[
            'reg'=>'/[\S]+/',
            'tips'=>'必填项不能为空'
        ],
        'url'=>[
            'reg'=>'/(^#)|(^http(s*):\/\/[^\s]+\.[^\s]+)/',
            'tips'=>'网址格式不正确'
        ],
        'date'=>[
            'reg'=>'/^(\d{4})[-\/](\d{1}|0\d{1}|1[0-2])([-\/](\d{1}|0\d{1}|[1-2][0-9]|3[0-1]))*$/',
            'tips'=>'日期格式不正确'
        ],
        'number'=>[
            'reg'=>'/^[0-9]+.?[0-9]*$/',
            'tips'=>'请输入数字'
        ],
        'identity'=>[
            'reg'=>'/(^\d{15}$)|(^\d{17}(x|X|\d)$)/',
            'tips'=>'请输入正确的身份证号'
        ]
    ];

    public function __construct()
    {
        parent::__construct();
        $this->id = uniqid();
        $this->module('form');
    }
    public function render($component = false)
    {
        if ($this->dataUrl) {
            $this->script[] = <<<EOD
        admin.ajax('{$this->dataUrl}','',function (data) {
            if (data.code == 1) {
                form.val("form-{$this->id}", data.data)
            } else {
                layer.msg(data.msg);
            }
        },'','{$this->dataMethod}');
EOD;
        }


        if ($this->rules) {
            //构建表单验证JS代码
            $verify = '';
            foreach ($this->rules as $key=>$val) {
                if (count($val)<3) {
                    continue;
                }
                if (!isset($this->formVerify[$val[1]])) {
                    continue;
                }

                $rule = $this->formVerify[$val[1]];
                if ($verify != '') {
                    $verify.=',';
                }
                $verify .= "{$val[1]}_{$val[0]}:function(value, item){\n";

                $verify.=!$val[2]?"if(value != ''){\n":'';
                $verify.= $val[3]!=0?"if(value.length<{$val[3]}){ return '该项长度不能小于{$val[3]}' }":'';
                $verify.= $val[4]!=0?"if(value.length>{$val[4]}){ return '该项长度不能大于{$val[4]}' }":'';
                $verify.="if(!{$rule['reg']}.test(value)){\n";
                $verify.="return '{$rule['tips']}';\n";
                $verify.="}\n";

                $verify.=!$val[2]?"}\n":'';

                $verify.="}\n";
            }

            $this->script[] = <<<EOD
            form.verify({
              {$verify}
            });
EOD;
        }

        if ($this->url) {
            $this->script[] = <<<EOD
        form.on('submit(form-{$this->id})', function (data) {
            admin.ajax('{$this->url}', data.field, function (data) {
                if (data.code == 1) {
                    layer.confirm(data.msg + ',是否继续?', {
                        icon: 3,
                        title: '提示',
                        btn: ['继续', '返回']
                    }, function (index) {
                        location.reload();
                    }, function () {
                        admin.closeSelf()
                    });
                } else {
                    layer.msg(data.msg);
                }
            },'','{$this->method}');
        });
EOD;
        }
        return $this->fetch($vars = [
            'builder'=> $this
        ], $component);
    }
}
