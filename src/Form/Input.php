<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/7
 * Time: 01:23
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Input extends Builder implements Render
{
    use Compoents,Field;

    public static $tmpl = 'form/input';

    public static $type = 'text';
    
}
