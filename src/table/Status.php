<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/4
 * Time: 21:35.
 */

namespace thans\layuiAdmin\Table;

use thans\layuiAdmin\Traits\Column;

class Status
{
    use Column;

    public $tmpl = 'table/status';

    public $type = 'text';

    public $options = [];

    public $field = 'status';

    public function option($val, $title, $type = 'primary')
    {
        $this->options[] = ['val' => $val, 'title' => $title, 'type' => $type];

        return $this;
    }

    public function options($arr = [])
    {
        $this->options = array_merge($this->options, $arr);

        return $this;
    }
}
