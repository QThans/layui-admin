<?php

namespace thans\layuiAdmin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name'             => ['require', 'regex' => '/^[a-z_A-Z\x{4e00}-\x{9fa5}][a-zA-Z0-9_\x{4e00}-\x{9fa5}]{4,50}$/u'],
        'nickname'         => 'require|max:50|min:5',
        'password'         => 'require|min:6|max:24',
        'confirm_password' => 'require|confirm:password',
        'mobile'           => 'require|mobile',
        'email|邮箱'         => 'require|email',
        'code'             => 'require|length:4',
    ];

    protected $message = [
        'name'             => '用户名必须5-50位，不能以数字开头',
        'nickname'         => '昵称必须5到50位，且不能出现空格',
        'password'         => '请输入正确的密码',
        'confirm_password' => '两次输入的密码不一样',
        'mobile'           => '请输入正确的手机号',
        'code'             => '请输入正确的验证码',
    ];

    public function sceneSave()
    {
        return $this->only(['name', 'nickname', 'password', 'email', 'mobile'])
            ->remove('mobile', 'require')
            ->remove('email', 'require');
    }

    public function sceneUpdate()
    {
        return $this->only(['name', 'nickname', 'password', 'email', 'mobile'])
            ->remove('mobile', 'require')
            ->remove('password', 'require')
            ->remove('email', 'require');
    }

    public function scenePersonal()
    {
        return $this->only(['nickname', 'password', 'confirm_password'])
            ->remove('confirm_password', 'require')
            ->remove('password', 'require');
    }
}
