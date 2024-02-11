<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Glacial\Template\TemplateEngine;

$config = [
    __DIR__ . '/components',
    __DIR__ . '/pages'
];
$template = new TemplateEngine($config);

echo $template->render('header', [
    'title' => 'my title',
]);