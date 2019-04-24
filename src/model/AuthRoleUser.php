<?php


namespace thans\layuiAdmin\model;

use think\model\concern\SoftDelete;
use think\model\Pivot;

class AuthRoleUser extends Pivot
{
    use SoftDelete;
    protected $name = 'auth_role_user';
    protected $autoWriteTimestamp = true;
}