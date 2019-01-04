<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Load;

class Form extends Builder
{
    use Load;

    public static $tmpl = 'form';

    public static $classMap = [
        'input' => Form\Input::class,
        'text' => Form\Text::class,
        'number' => Form\Number::class,
        'select' => Form\Select::class,
        'onoff' => Form\Onoff::class,
    ];

    public function __construct()
    {
        parent::__construct();
        $this->module('form');
        self::$script[] = $this->formVerify;
    }
}
