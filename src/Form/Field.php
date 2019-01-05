<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:35
 */

namespace thans\layuiAdmin\Form;

trait Field
{
    public $label = '';

    public $name = '';

    public $value = '';

    public $tips = '';

    public $rules = '';

    public $attr = [];

    public $regs = [];

    public function attr($type = '', $val = '')
    {
        if (isset($this->$type)) {
            $this->$type = $val;
            return $this;
        }
        $this->attr[$type] = $val;
        return $this;
    }

    public function rules($rules = '', $regs = [])
    {
        if (!empty($regs)) {
            $this->regs = array_merge($regs, $this->regs);
        }
        $this->rules = $rules;
        return $this;
    }
}
