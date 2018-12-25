<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:21
 */

namespace thans\layuiAdmin\Form;

class Number extends Input
{
    public function __construct($arguments = [])
    {
        parent::__construct($arguments);
        self::$type = 'number';
        return $this;
    }
}
