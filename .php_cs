<?php
$header = <<<EOF
This file is part of the thans/layui-admin.

(c) Thans <thans@thans.cn>

This source file is subject to the Apache2.0 license that is bundled.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@PSR2' => true,
        'header_comment' => array('header' => $header),
        'array_syntax' => array('syntax' => 'short'),
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;