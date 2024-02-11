<?php declare(strict_types=1);

namespace Photon\Template;

class TemplateEngine {
    private array $config;

    function __construct(array $config = []) {
        $this->config = $config;
    }

    public function render(string $slug, array $args = []) {
        $slug = $slug.'.php';
        $paths = $this->config;

        $paths = array_map(function($path) use ($slug) {
            return $path . '/' . $slug;
        }, $paths);

        $file = '';

        foreach($paths as $p) {
            if(is_file($p)) {
                $file = $p;
                break;
            }
        }

        if(!$file) {
            $err = 'Unable to locate template file: ';
            trigger_error($err . $slug, E_USER_WARNING);
            return;
        }

        extract($args, EXTR_SKIP);
        foreach($args as $value) {
            $value = htmlspecialchars($value);
            return $value;
        }

        ob_start();
        include($file);
        $output = ob_get_clean();
        return $output;
    }
};

$config = [
    __DIR__ . '/components',
    __DIR__ . '/pages'
];
$template = new TemplateEngine($config);

echo $template->render('header', [
    'title' => 'my title',
]);