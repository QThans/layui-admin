<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

if (! function_exists('scan_dir')) {
    /**
     * 扫描目录.
     *
     * @param  string 目录
     * @param  int 层级
     * @param  int 当前层级
     *
     * @return array
     */
    function scan_dir($dir, $depth = 0, $now = 0)
    {
        $dirs = [];
        if (! is_dir($dir) || ($now >= $depth && $depth != 0)) {
            return false;
        }
        $dirArr = glob("$dir/*");
        $now++;
        foreach ($dirArr as $item) {
            if (is_dir($item)) {
                $dirs[] = $item;
                $subDir = scan_dir($item, $depth, $now);
                if ($subDir) {
                    $dirs = array_merge($dirs, $subDir);
                }
            }
        }

        return $dirs;
    }
}

if (! function_exists('copy_dir')) {
    /**
     * 复制目录.
     *
     * @param  string  $dir   目录
     * @param  string  $dest  目标目录
     *
     * @return bool
     */
    function copy_dir($dir, $dest = '')
    {
        if (! is_dir($dir)) {
            return false;
        }
        @mkdir($dest, 0777, true);
        $resources = scandir($dir);
        foreach ($resources as $item) {
            if (is_dir($dir.DIRECTORY_SEPARATOR.$item) && $item != '.'
                && $item != '..'
            ) {
                copy_dir($dir.DIRECTORY_SEPARATOR.$item,
                    $dest.DIRECTORY_SEPARATOR.$item);
            } elseif (is_file($dir.DIRECTORY_SEPARATOR.$item)) {
                copy($dir.DIRECTORY_SEPARATOR.$item,
                    $dest.DIRECTORY_SEPARATOR.$item);
            }
        }

        return true;
    }
}
if (! function_exists('view_path')) {
    /**
     * 获取模板具体目录.
     *
     * @return string
     */
    function view_path()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'
            .DIRECTORY_SEPARATOR;
    }
}
if (! function_exists('encrypt_password')) {
    /**
     * 密码加密.
     *
     * @param  string  $password  原密码
     * @param  string  $salt      盐值
     *
     * @return string
     */
    function encrypt_password($password, $salt)
    {
        $block_count = ceil(strlen($salt) / strlen($password));
        $output      = '';
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt.pack('N', $i);
            // first iteration
            $last = $xorsum = hash_hmac('sha256', $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < strlen($last); $j++) {
                $xorsum ^= ($last = hash_hmac('sha1', $last, $password, true));
            }
            $output .= $xorsum;
        }

        return bin2hex(hash_hmac('sha512', $salt, $output, true));
    }
}
if (! function_exists('random_str')) {
    /**
     * 随机字符串.
     *
     * @param  int   $length   随机长度
     * @param  bool  $numeric  是否只取数字
     * @param  bool  $lower    是否小写
     *
     * @return string
     */
    function random_str($length = 6, $numeric = false, $lower = false)
    {
        $map
                   = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $maxLength = $numeric ? 9 : 62;
        $str       = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $map[rand(0, $maxLength)];
        }

        return $lower ? strtolower($str) : $str;
    }
}
if (! function_exists('assoc_unique')) {
    function assoc_unique($arr, $key)
    {
        $tmp_arr = [];
        foreach ($arr as $k => $v) {
            if (in_array($v[$key],
                $tmp_arr)
            ) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序

        return $arr;
    }
}
/**
 * 获取唯一值
 */
if (! function_exists('rand_uniqid')) {
    function rand_uniqid()
    {
        return md5(uniqid(rand()));
    }
}
if (! function_exists('filesize_format_human')) {
    function filesize_format_human($num)
    {
        $p = 0;
        $format = 'bytes';
        if ($num > 0 && $num < 1024) {
            $p = 0;
            return number_format($num) . ' ' . $format;
        }
        if ($num >= 1024 && $num < pow(1024, 2)) {
            $p = 1;
            $format = 'KB';
        }
        if ($num >= pow(1024, 2) && $num < pow(1024, 3)) {
            $p = 2;
            $format = 'MB';
        }
        if ($num >= pow(1024, 3) && $num < pow(1024, 4)) {
            $p = 3;
            $format = 'GB';
        }
        if ($num >= pow(1024, 4) && $num < pow(1024, 5)) {
            $p = 3;
            $format = 'TB';
        }
        $num /= pow(1024, $p);
        return number_format($num, 3) . ' ' . $format;
    }
}
