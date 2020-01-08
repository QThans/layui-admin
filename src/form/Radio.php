<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/9
 * Time: 14:34.
 */

namespace thans\layuiAdmin\form;

use thans\layuiAdmin\facade\Jump;
use thans\layuiAdmin\Traits\Field;

class Radio
{
    use Field;

    public $tmpl = 'form/radio';

    public $type = 'radio';

    public $options = [];

    public function option($val, $title = '',$disabled = false)
    {
        if (is_array($val)) {
            $this->options = array_merge($this->options, $val);

            return $this;
        }
        $this->options[] = ['val'=>$val, 'title'=>$title,'disabled'=>$disabled];

        return $this;
    }

    public function options($vals)
    {
        $this->options = $vals;

        return $this;
    }
    public function end()
    {
        if(!$this->options){
            Jump::result('Radio组件参数[options]错误','','请联系开发人员');
        }
    }
}
