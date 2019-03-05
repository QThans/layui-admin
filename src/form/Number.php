<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:21
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Traits\Compoents;
use thans\layuiAdmin\Traits\Field;
class Number
{
    use Compoents,Field;

    public $tmpl = 'form/input';

    public $type = 'number';
}
