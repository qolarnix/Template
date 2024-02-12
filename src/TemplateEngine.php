<?php declare(strict_types=1);

namespace Glacial\Template;

class TemplateEngine {
    private array $config;

    function __construct(array $config = []) {
        $this->config = $config;
    }

    public function render(string $slug, array $args = []) {
        $slug = $slug.'.php';
        $paths = $this->config;

        $view = new View();
        array_push($args, $view);

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

        ob_start();
        include($file);
        $output = ob_get_clean();
        return $output;
    }
}

class View extends TemplateEngine {
    public function escape(string $val) {
        return htmlentities($val);
    }
};