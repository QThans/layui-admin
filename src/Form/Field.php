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

    public function attr($type = '', $val = '')
    {
        if (isset($this->$type)) {
            $this->$type = $val;
            return $this;
        }
        $this->attr[$type] = $val;
        return $this;
    }

    public function rules($rules = '', $required = true, $min = 0, $max = 0)
    {
        $id = uniqid();
        $this->rules = $rules.'_'.$id;
        $this->obj->rules[] = [$id,$rules,$required,$min,$max];//向Form类里面添加规则，用户编译
        return $this;
    }
}
