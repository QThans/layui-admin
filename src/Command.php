<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use think\console\Input;
use think\console\Output;

class Command extends \think\console\Command
{
    public function configure()
    {
        $this->setName('layuiAdmin:install')
            ->setDescription('install layui-admin');
    }

    public function execute(Input $input, Output $output)
    {
        $this->createConfig($output);
        $this->createStatic($output);
        $this->createMigrations($output);
    }

    public function createConfig($output)
    {
        $configFilePath = app()->getAppPath().'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'admin.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config file is exist');
        } else {
            $res = copy(__DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'admin.php', $configFilePath);
            if ($res) {
                $output->writeln('Create config file success:'.$configFilePath);
            } else {
                $output->writeln('Create config file error');
            }
        }
    }

    public function createMigrations($output)
    {
        $migrationsPath = app()->getAppPath().'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
        copy_dir(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations', $migrationsPath);
        $output->writeln('Copy database margrations end');
    }

    public function createStatic($output)
    {
        $staticPath = app()->getAppPath().'..'.DIRECTORY_SEPARATOR.'public'.
            DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'layui-admin'.DIRECTORY_SEPARATOR;
        copy_dir(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'static', $staticPath);
        $output->writeln('Copy resources end');
    }
}
