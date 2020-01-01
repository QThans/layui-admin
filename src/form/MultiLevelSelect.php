<?php


namespace thans\layuiAdmin\form;

//多级联动
use thans\layuiAdmin\Traits\Field;

class MultiLevelSelect
{
    use Field;

    public $tmpl = 'form/multi_level_select';

    public $search = true;
}
