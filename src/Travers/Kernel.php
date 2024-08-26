<?php

namespace Travers;

use InvalidArgumentException;
use Travers\Interfaces\ArticlesInterface;

final class Kernel
{
    private function __clone() {}
    private function __construct() {}

    static public function validateConfig(string $config_path): array
    {
        if (!file_exists($config_path)) {
            throw new InvalidArgumentException("Config not found: " . $config_path);
        }

        return require_once $config_path;
    }

    static public function runMiddlewaresChain(ArticlesInterface $articles, array $middlewares): ArticlesInterface
    {
        foreach ($middlewares as $middleware_config) {
            $middleware_name = is_string($middleware_config) ? $middleware_config : $middleware_config['name'];
            $middleware_class = 'Travers\\Middlewares\\' . $middleware_name . '\\Middleware';

            if (class_exists($middleware_class)) {
                $middleware = new $middleware_class();
                if (method_exists($middleware, 'main')) {
                    IO::textDebug('Entering middleware: ' . $middleware_name);
                    $articles = $middleware->main($articles);
                } else {
                    throw new InvalidArgumentException("Method 'main' not found in $middleware_class");
                }
            } else {
                throw new InvalidArgumentException("Middleware class $middleware_class not found");
            }

            unset($middleware);
        }

        return $articles;
    }
}
