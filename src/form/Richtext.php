<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\form;

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
            $config .= "var richtext_config_{$this->id} = CKEDITOR.config; richtext_config_{$this->id}.{$key} = '{$value}';";
        }
        $this->obj->builder->script(
            'richtext_'.$this->id,
            <<<EOD
        $config
        var richtext_{$this->id} =  CKEDITOR.replace('{$this->id}',richtext_config_{$this->id});
        richtext_{$this->id}.on( 'change', function( evt ) {
            $('#{$this->id}').html(evt.editor.getData());
        });
EOD
);
        $setValueScript = $this->name?"$('textarea[name=\"{$this->name}\"]').html(data.data.{$this->name});richtext_{$this->id}.setData(data.data.{$this->name});":'';
        $this->obj->setValueScript('richtext_'.$this->id,$setValueScript);
    }
    public function config($key, $value)
    {
        $this->config[$key] = $value;
    }
}
