<?php declare(strict_types=1);

use Glacial\Template\TemplateEngine;

require __DIR__ . '/../vendor/autoload.php';

$config = [
    __DIR__ . '/components',
    __DIR__ . '/pages',
];
$template = new TemplateEngine($config);

echo $template->render('header', [
    'title' => 'test',
    'desc' => 'lorem ipsum dolor sit amet',
    'htmlval' => '<script>alert(1);</script>',
    'list' => [
        'this' => 'that'
    ],
]);