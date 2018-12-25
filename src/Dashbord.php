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

class Dashbord extends Builder
{
    use Load;

    public static $tmpl = 'dashbord';

    public static $classMap = [
        'card' => Dashbord\Card::class,
    ];
}
