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

    public $classMap = [
        'input' => Form\Input::class,
        'text' => Form\Text::class,
        'number' => Form\Number::class,
        'select' => Form\Select::class,
        'onoff' => Form\Onoff::class,
    ];

    public function __construct()
    {
        parent::__construct();
        $this->id = uniqid();
        $this->module('form');
        $this->script[] = $this->formVerify;

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
