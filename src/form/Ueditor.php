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

class Ueditor
{
    use Field;

    public $options = [];

    public $tmpl = 'form/ueditor';
    /**
     * 图片上传接口开发参考：http://fex.baidu.com/ueditor/#server-path
     * layuiadmin默认接口：url('thans\layuiAdmin\controller\Upload@image',['type'=>'ue'])
     * @package thans\layuiAdmin\form
     */
    public $imageUploadUrl = '';

    public function init()
    {
        $this->obj->builder->js('ueditor_config', 'vendor/layui-admin/ueditor/ueditor.config.js');
        $this->obj->builder->js('ueditor', 'vendor/layui-admin/ueditor/ueditor.all.min.js');
    }

    public function end()
    {
        $config = '';
        $data = json_encode($this->obj->data, JSON_UNESCAPED_UNICODE);
        $this->obj->builder->script(
            'ueditor_'.$this->id,
            <<<EOD
            var data = {$data};
            var ueditor_{$this->id} = UE.getEditor('{$this->id}');
            ueditor_{$this->id}.ready(function(){
                $('#{$this->id}').attr('style','');
                ueditor_{$this->id}.addListener("blur",function(){
                    var content =ueditor_{$this->id}.getContent();
                    $('textarea[name="{$this->name}"]').val(content)
                })
            });
EOD
        );
        $setValueScript = '';
        $this->obj->setValueScript('ueditor_'.$this->id, $setValueScript);
    }
    public function config($key, $value)
    {
        $this->config[$key] = $value;
    }
}
