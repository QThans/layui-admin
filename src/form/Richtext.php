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
        $data = json_encode($this->obj->data, JSON_UNESCAPED_UNICODE);
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
        console.log(evt.editor.getData())
            $('#{$this->id}').val(evt.editor.getData());
        });
        var data = {$data};
EOD
        );
        $setValueScript = $this->name ? "$('textarea[name=\"{$this->name}\"]').html(data.content);richtext_{$this->id}.setData(data.content);" : '';
        $this->obj->setValueScript('richtext_'.$this->id, $setValueScript);
    }

    public function config($key, $value)
    {
        $this->config[$key] = $value;
    }
}
