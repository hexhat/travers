<?php

namespace Travers\Middlewares\DummyMiddleware;

use Travers\Interfaces\ArticlesInterface;
use Travers\Interfaces\MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    public function __construct() {}

    public function main(ArticlesInterface $articles): ArticlesInterface
    {
        text('Hello from TestModule2!');
        text(__FILE__);

        $articles->mapBody(function ($article) {
            (gettype($article['body']) === 'integer') ? $article['body'] += 1 : $article['body'] = 1;
            return $article;
        });

        return $articles;
    }
}