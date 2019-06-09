<?php

namespace thans\layuiAdmin\facade;

use think\Facade;

class Json extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\layuiAdmin\tool\Json';
    }
}
