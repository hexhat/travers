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
        foreach ($middlewares as $middlewareConfig) {
            $middlewareName = is_string($middlewareConfig) ? $middlewareConfig : $middlewareConfig['name'];
            $middlewareClass = 'Travers\\Middlewares\\' . $middlewareName . '\\Middleware';

            if (class_exists($middlewareClass)) {
                $middleware = new $middlewareClass();
                if (method_exists($middleware, 'main')) {
                    textVerbose('Entering middleware: ' . $middlewareName);
                    $articles = $middleware->main($articles);
                } else {
                    throw new InvalidArgumentException("Method 'main' not found in $middlewareClass");
                }
            } else {
                throw new InvalidArgumentException("Middleware class $middlewareClass not found");
            }
            unset($middleware);
        }

        return $articles;
    }
}
