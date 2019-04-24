<?php


namespace thans\layuiAdmin\model;


use think\Model;
use think\model\concern\SoftDelete;

class AuthRoleMenu extends Model
{
    use SoftDelete;

    protected $name = 'auth_role_menu';
}