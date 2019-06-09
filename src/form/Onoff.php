<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/9
 * Time: 14:34.
 */

namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;

class Onoff
{
    use Field;

    public $tmpl = 'form/onoff';

    public $type = 'checkbox';

    public function text($text)
    {
        $this->attr('lay-text', $text);

        return $this;
    }
}
