<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\Traits;

trait Field
{
    use Compoents;
    public $label = '';

    public $name = '';

    public $value = '';

    public $tips = '';

    public $rules = '';

    public $placeholder = '';

    public $attr = [];

    public function value($val = '')
    {
        $this->value = $val;
        return $this;
    }

    public function attr($type = '', $val = '')
    {
        if (isset($this->$type)) {
            $this->$type = $val;
            return $this;
        }
        $this->attr[$type] = $val;
        return $this;
    }

    public function placeholder($val = '')
    {
        $this->placeholder = $val;
        return $this;
    }

    public function hide()
    {
        if (isset($this->attr['style'])) {
            $this->attr['style'] = 'display:none;' . $this->attr['style'];
        } else {
            $this->attr['style'] = 'display:none;';
        }
        return $this;
    }

    public function render()
    {
        if (method_exists($this, 'end')) {
            $this->end();
        }
        $render = $this->obj->builder->display($this->tmpl, [
            'self' => $this
        ], true);
        $this->obj->field[] = $render;
        return $this;
    }

    public function rules($rules = '', $tips = '', $required = true, $min = 0, $max = 0)
    {
        $id = uniqid();
        $this->rules =  'rule_' . $id;
        $this->obj->rules[] = [
            'id' => $id,
            'rules' => $rules,
            'required' => $required,
            'min' => $min,
            'max' => $max,
            'tips' => $tips
        ];
        return $this;
    }
}
