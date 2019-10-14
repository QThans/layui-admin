<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/4
 * Time: 21:35.
 */

namespace thans\layuiAdmin\Table;

use thans\layuiAdmin\Traits\Column;

class Icon
{
    use Column;

    public $tmpl = 'table/icon';

    public $value = '';

    public $field = 'icon';
}
