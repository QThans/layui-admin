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

class Checkbox extends Builder implements Render
{
    use Compoents,Field;

    public $tmpl = 'form/checkbox';

    public $type = 'checkbox';

    public function title($text)
    {
        $this->attr('title', $text);
        return $this;
    }
    public function skin($skin)
    {
        $this->attr('lay-skin', $skin);
        return $this;
    }
}
