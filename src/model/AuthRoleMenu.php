<?php


namespace thans\layuiAdmin\model;


use think\model\concern\SoftDelete;
use think\model\Pivot;

class AuthRoleMenu extends Pivot
{
    use SoftDelete;

    protected $name = 'auth_role_menu';
}