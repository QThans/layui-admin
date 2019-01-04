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

class Status extends Builder implements Render
{
    use Compoents;

    public static $tmpl = 'table/status';

    public static $type = 'text';

    public static $options = [];

    public static $field = 'status';

    public function option($val, $title, $type='primary')
    {
        self::$options[] = ['val'=>$val,'title'=>$title,'type'=>$type];
        return $this;
    }
}
