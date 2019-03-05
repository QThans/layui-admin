<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:32
 */

namespace thans\layuiAdmin\Form;

use thans\layuiAdmin\Traits\Field;
class Select
{
    use Field;

    public $tmpl = 'form/select';

    public $options = [];

    public $search = true;

    public function option($val, $title = '')
    {
        if (is_array($val)) {
            $this->options = array_merge($this->options, $val);
            return $this;
        }
        $this->options[] = ['val'=>$val,'title'=>$title];
        return $this;
    }
    //TODO AJAX关联数据
    public function relation($url, $label, $value)
    {
        $this->obj->module('jquery');
        $js[] = <<<EOD
            admin.ajax('{$url}', '', function (data) {
            if (data.code == 1) {
                $.each(data.data, function (index, value) {
                    var isSelect = '';
                    if(value.{$value} == {$this->value}){
                        var isSelect = 'selected';
                    }
                    $('select[name="{$this->name}"]').append('<option '+isSelect+' value="' + value.{$value} + '">' + value.{$label} + '</option>');
                })
                form.render('select');
            } else {
                layer.msg(data.msg);
            }
        }, '', 'get',false);
EOD;
        array_unshift($this->obj->script, $js);
        return $this;
    }
}
