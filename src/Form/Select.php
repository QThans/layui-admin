<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:32
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Select extends Builder implements Render
{
    use Compoents, Field;
    public static $tmpl = 'form/select';

    public static $options = [];

    public static $search = true;

    public function option($val, $title)
    {
        self::$options[$val] = $title;
        return $this;
    }
    //TODO AJAX关联数据
    public function relation($url)
    {
        $this->script(self::$name, '');
        return $this;
    }
}
