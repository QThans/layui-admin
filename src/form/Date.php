<?php


namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;

class Date
{
    use Field;

    public $tmpl = 'form/date';

    public $format = '';

    public $type = 'date';

    public $range = false;

    public $isInitValue = false;

    public $min = '1900-1-1';

    public $max = '2099-12-31';
    //abolute fixed static
    public $position = 'abolute';

    public $showBottom = true;

    public $btns = ["clear","now","confirm"];

    public $lang = 'cn';

    public $theme = 'default';

    public function btns($val = [])
    {
        $this->btns = $val;
        return $this;
    }

    public function end()
    {
        $this->obj->module('laydate');
        $this->range = $this->range ? 'true' : 'false';
        $format = $this->format ? ',format:' . $this->format : '';
        $isInitValue = $this->isInitValue ? ',isInitValue:true' : ',isInitValue:false';
        $showBottom = $this->showBottom ? ',showBottom:true' : ',showBottom:false';
        $this->btns = json_encode($this->btns);
        $this->obj->script('laydate_' . $this->id, <<<EOT
laydate.render({ 
  elem: '#{$this->id}'
  ,type: '{$this->type}'
  ,range:{$this->range}
  {$format}
  {$isInitValue}
  ,min: '{$this->min}'
  ,max: '{$this->max}'
  ,position: '{$this->position}'
  {$showBottom}
  ,btns: {$this->btns}
  ,lang:'{$this->lang}'
  ,theme:'{$this->theme}'
});
EOT
        );
    }
}
