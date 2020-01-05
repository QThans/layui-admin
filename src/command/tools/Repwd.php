<?php

namespace thans\layuiAdmin\command\tools;

use thans\layuiAdmin\model\Admins;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;
use think\console\input\Option;

class Repwd extends \think\console\Command
{
    public function configure()
    {
        $this->setName('layuiAdmin:repwd')
            ->addOption('pwd', '-p', Option::VALUE_REQUIRED, "your admin's password.if pwd is null,the password will be random")
            ->setDescription("reset your admin's password");
    }

    public function execute(Input $input, Output $output)
    {
        $pwd = $this->repwd($input->getOption('pwd'));
        $output->writeln("Your admin's new password is " . $pwd);
    }
    public function repwd($pwd)
    {
        $pwd = $pwd ? $pwd : random_str(6);
        Admins::update(['password' => $pwd], ['id' => 1]);
        return $pwd;
    }
}
