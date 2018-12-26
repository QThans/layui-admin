<?php
/*
 * @Description:
 * @Author: Thans
 * @Date: 2018-12-05 21:02:44
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
    }
    public function createConfig($output)
    {
        $configFilePath = env('app_path') . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'layui.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config file is exist');
        } else {
            $res = copy(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'layui.php', $configFilePath);
            if ($res) {
                $output->writeln('Create config file success:' . $configFilePath);
            } else {
                $output->writeln('Create config file error');
            }
        }
    }
    public function createStatic($output)
    {
        $staticPath = env('app_path') . '..' . DIRECTORY_SEPARATOR . 'public' .
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'layui-admin' . DIRECTORY_SEPARATOR;
        copy_dir(__DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'static', $staticPath);
        $output->writeln('Copy resources End');
    }
}
