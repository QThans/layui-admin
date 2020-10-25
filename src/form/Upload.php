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

class Upload
{
    use Field;
    public $tmpl = 'form/upload';
    public $uploadType = 'image';
    //上传接口
    public $url = '';
    //上传接口额外参数
    public $data = [];
    //文件上传headers
    public $headers = [];
    //上传成功代码
    public $successCode = 0;
    //上传文件后缀，默认图片
    public $exts = '';
    //设定文件域的字段名
    public $field = 'file';
    //规定打开文件选择框时，筛选出的文件类型，值为用逗号隔开的 MIME 类型列表
    public $acceptMime = 'image/*';
    //设置文件最大可允许上传的大小，单位 KB 0 不限制
    public $size = 0;
    //是否开启多文件。
    public $multiple = false;
    //设置同时可上传的文件数量
    public $number = 1;
    //多文件参数
    public $many = '';

    public function many($array)
    {
        if ($this->multiple) {
            $this->many = '[]';
        }

        return $this;
    }
    public function end()
    {
        $this->obj->module('upload');
        $code = $this->obj->builder->display(__DIR__.DIRECTORY_SEPARATOR.'stub'
            .DIRECTORY_SEPARATOR.'upload.js.stub', $vars = [
            'self' => $this,
        ]);
        $this->obj->script('upload_js_'.$this->id, $code);
        $this->obj->submitStartSctipt(
            'upload_start_script_'.$this->id,
            'delete data.field.'.$this->field.';'
        );
        $val    = isset($this->obj->data[$this->name])
            ? $this->obj->data[$this->name] : '';

        if (empty($val)) {
            return $this->obj->setValueScript('upload_' . $this->id, '');
        }

        $script = '';
        if (is_array($val) && $val) {
            foreach ($val as $k => $v) {
                $script .= $this->appendInput($k, $v);
                $script .= $this->appendView($k, $v);
            }
        } elseif ($val) {
            $script = $this->appendInput(0, $val);
            $script .= $this->appendView(0, $val);
        }

        $this->obj->setValueScript('upload_'.$this->id, $script);
    }

    protected function appendInput($k, $val)
    {
        if ($this->multiple) {
            $this->many = '[]';
        }
        return <<<EOD
$('#{$this->id}_upload_list').append('<input name="{$this->name}{$this->many}" type="hidden" class="{$this->multiple} value_{$this->id}_{$k}" value="{$val}">');
number_{$this->id}++;
EOD;
    }

    protected function appendView($k, $v)
    {
        if ($this->uploadType == 'image') {
            return <<<EOD
                $('#{$this->id}_upload_list').append('<div id="dim_{$this->id}_$k" class="dimback"><img id="file_{$this->id}_$k" src="$v" alt="" class="layui-upload-img  view_{$this->id}" ><span class="status_$k">已上传</span><i data-id="$k" class="layui-icon-close layui-icon removeimg_{$this->id}"></i></div>');
EOD;
        } else {
            return <<<EOD
                $('#{$this->id}_upload_list').append('<div id="dim_{$this->id}_$k" class="dimback dimback-file"><p id="file_{$this->id}_$k"  class="layui-upload-file-name" >$v</p><span class="status_$k">已上传</span><i data-id="$k" class="layui-icon-close layui-icon removeimg_{$this->id}"></i></div>');
EOD;
        }
    }
}
