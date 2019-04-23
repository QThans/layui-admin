<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/4
 * Time: 21:35
 */

namespace thans\layuiAdmin\Table;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Icon
{
    use Compoents;

    public $tmpl = 'table/icon';

    public $value = '';

    public $field = 'icon';

}
