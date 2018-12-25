<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/9
 * Time: 14:34
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Onoff extends Input
{
    public function __construct($arguments = [])
    {
        parent::__construct($arguments);
        self::$type = 'checkbox';
        $this->attr('lay-skin', 'switch');
        return $this;
    }
    public function text($text)
    {
        $this->attr('lay-text', $text);
        return $this;
    }
}
