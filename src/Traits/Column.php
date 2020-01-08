<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\Traits;

trait Column
{
    use Compoents;

    public function column($field, $title, $width = 200, $attr = [])
    {
        $this->field = $field;
        $attr['templet'] = '#'.$field.'_'.$this->id;
        $this->obj->column($field, $title, $width, $attr);

        return $this;
    }
}
