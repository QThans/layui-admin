<?php
/*
 * @Description:
 * @Author: Thans
 * @Date: 2018-12-05 20:59:14
 */
\think\Console::addDefaultCommands([
    \thans\layuiAdmin\Command::class,
]);
if (!function_exists('sub_dir')) {
    function scan_dir($dir, $depth = 0, $now = 0)
    {
        $dirs = [];
        if (!is_dir($dir) || ($now >= $depth && $depth!=0)) {
            return false;
        }
        $dirArr = glob("$dir/*");
        $now++;
        foreach ($dirArr as $item) {
            if (is_dir($item)) {
                $dirs[] = $item;
                $subDir = sub_dir($item, $depth, $now);
                if ($subDir) {
                    $dirs = array_merge($dirs, $subDir);
                }
            }
        }
        return $dirs;
    }
}
if (!function_exists('copy_dir')) {
    function copy_dir($dir, $dest = '')
    {
        if (!is_dir($dir)) {
            return false;
        }
        @mkdir($dest, 0777, true);
        $resources = scandir($dir);
        foreach ($resources as $item) {
            if (is_dir($dir.DIRECTORY_SEPARATOR.$item) && $item != '.' && $item != '..') {
                copy_dir($dir.DIRECTORY_SEPARATOR.$item, $dest.DIRECTORY_SEPARATOR.$item);
            } elseif (is_file($dir.DIRECTORY_SEPARATOR.$item)) {
                copy($dir.DIRECTORY_SEPARATOR.$item, $dest.DIRECTORY_SEPARATOR.$item);
            }
        }
        return true;
    }
}
if (!function_exists('view_path')) {
    function view_path()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
    }
}
