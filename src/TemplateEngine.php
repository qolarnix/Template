<?php declare(strict_types=1);

namespace Glacial\Template;

use Exception;

class TemplateEngine {
    private array $config;

    function __construct(array $config = []) {
        $this->config = $config;
    }

    public function render(string $slug, array $args = []): string|Exception {
        $slug = $slug.'.php';
        $paths = $this->config;

        $view = new View($paths);
        array_push($args, $view);

        $paths = array_map(function($path) use($slug) {
            return $path . '/' . $slug;
        }, $paths);

        $file = '';
        foreach($paths as $p) {
            if(is_file($p)) {
                $file = $p;
                break;
            }
        }
        if(!$file) return new Exception('Unable to locate template file: ' . $slug);

        extract($args, EXTR_SKIP);

        ob_start();
        include($file);
        return ob_get_clean();
    }
}

class View extends TemplateEngine {
    public function __construct(array $config = []) {
        parent::__construct($config);
    }

    public function escape(string $val, string $mods = ''): string {
        if(!$mods) {
            return htmlspecialchars($val);
        }
        else {
            $mods = explode('|', $mods);

            foreach($mods as $m) {
                if(method_exists($this, $m)) {
                    $val = call_user_func(__NAMESPACE__ . '\View::' . $m, $val);
                }
            }

            return htmlspecialchars($val);
        }
    }

    static public function uppercase(string $val): string {
        return strtoupper($val);
    }

    static public function lowercase(string $val): string {
        return strtolower($val);
    }

    static public function randomize(string $val): string {
        return str_shuffle($val);
    }
}