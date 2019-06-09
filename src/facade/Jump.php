<?php

namespace thans\layuiAdmin\facade;

use think\Facade;

class Jump extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\layuiAdmin\tool\Jump';
    }
}
