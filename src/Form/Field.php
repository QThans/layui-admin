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
    public static $label = '';

    public static $name = '';

    public static $value = '';

    public static $tips = '';

    public static $rules = '';

    public static $attr = [];

    public static $regs = [];


    public function attr($type = '', $val = '')
    {
        if (isset(self::$$type)) {
            self::$$type = $val;
            return $this;
        }
        self::$attr[$type] = $val;
        return $this;
    }

    public function rules($rules = '', $regs = [])
    {
        if (!empty($regs)) {
            self::$regs = array_merge($regs, self::$regs);
        }
        self::$rules = $rules;
        return $this;
    }
}
