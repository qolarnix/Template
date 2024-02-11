# Glacial Template Engine

Simple templating engine for PHP projects.

### Get Started
`composer require glacial/template`

### Example Setup

```php
use Glacial\Template\TemplateEngine;

$config = [
    __DIR__ . '/components',
    __DIR__ . '/pages'
];

$template = new TemplateEngine($config);

echo $template->render('header', [
    'title' => 'my title',
]);
```