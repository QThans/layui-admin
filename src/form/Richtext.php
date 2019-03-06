<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Traits\Field;

class Richtext
{
    use Field;

    public $options = [];

    public $tmpl = 'form/richtext';

    public function init()
    {
        $this->obj->builder->js('richtext', 'vendor/layui-admin/ckeditor/ckeditor.js');
    }
    public function end()
    {
        $this->obj->builder->script('richtext', "CKEDITOR.replace('{$this->id}');");
    }
    public function option($key, $value)
    {
        $this->options[$key] = $value;
    }
}
