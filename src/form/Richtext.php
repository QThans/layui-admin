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
    //图片上传接口开发参考：https://ckeditor.com/docs/ckeditor4/latest/guide/dev_file_upload.html
    public $imageUploadUrl = '';
    public function init()
    {
        $this->obj->builder->js('richtext', 'vendor/layui-admin/ckeditor/ckeditor.js');
    }
    public function end()
    {
        $config = '';
        $this->config('filebrowserImageUploadUrl', $this->imageUploadUrl);
        foreach ($this->config as $key => $value) {
            $config .= "CKEDITOR.config.{$key} = '{$value}';";
        }
        $this->obj->builder->script(
            'richtext',
            <<<EOD
        $config
        CKEDITOR.replace('{$this->id}',CKEDITOR.config);
EOD
);
    }
    public function config($key, $value)
    {
        $this->config[$key] = $value;
    }
}
