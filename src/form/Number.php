<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:21.
 */

namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;

class Number
{
    use Field;

    public $tmpl = 'form/input';

    public $type = 'number';
}
