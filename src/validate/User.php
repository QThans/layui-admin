<?php


namespace thans\layuiAdmin\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name' => 'require|max:50|min:5',
        'nickname' => 'require|max:50|min:5',
        'password' => 'require|min:6',
        'confirm_password' => 'require|confirm:password',
        'mobile' => ['require', 'regex' => '/^1\d{10}$/'],
        'code' => 'require|length:4',
    ];

    protected $message = [
        'name' => '用户名必须5到50位，且不能出现空格',
        'nickname' => '昵称必须5到50位，且不能出现空格',
        'password' => '请输入正确的密码',
        'confirm_password' => '两次输入的密码不一样',
        'mobile' => '请输入正确的手机号',
        'code' => '请输入正确的验证码',
    ];

    public function scenePersonal()
    {
        return $this->only(['nickname', 'password', 'confirm_password'])
            ->remove('confirm_password', 'require')
            ->remove('password', 'require');
    }
}