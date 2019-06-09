<?php

namespace thans\layuiAdmin\model;

use think\model\Pivot;

class AuthRoleUser extends Pivot
{
    protected $name = 'auth_role_user';
    protected $autoWriteTimestamp = true;
}
