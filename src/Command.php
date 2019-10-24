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
        $path = app()->getAppPath().'..'.DIRECTORY_SEPARATOR.'.env';
        if (file_exists($path)
            && strpos(file_get_contents($path), '[FILESYSTEM]')
        ) {
            $output->writeln('filesystem is configured');
        } else {
            file_put_contents($path,
                PHP_EOL."[FILESYSTEM]".PHP_EOL."DRIVER=public".PHP_EOL,
                FILE_APPEND);
            $output->writeln('filesystem has configured');
        }
    }

    public function createMigrations($output)
    {
        $migrationsPath = app()->getAppPath().'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
        copy_dir(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations',
            $migrationsPath);
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
