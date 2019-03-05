<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/9
 * Time: 14:34
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Traits\Compoents;
use thans\layuiAdmin\Traits\Field;
class Onoff
{

    use Compoents,Field;

    public $tmpl = 'form/onoff';

    public $type = 'checkbox';

    public function text($text)
    {
        $this->attr('lay-text', $text);
        return $this;
    }
}
