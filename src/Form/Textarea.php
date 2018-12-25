<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/9
 * Time: 16:50
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Textarea extends Builder implements Render
{
    use Compoents,Field;
}
