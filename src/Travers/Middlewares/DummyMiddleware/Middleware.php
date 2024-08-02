<?php

namespace Travers\Middlewares\DummyMiddleware;

use Travers\Interfaces\ArticlesInterface;
use Travers\Interfaces\MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    public function __construct() {}

    public function setFilePath(): string
    {
        return __FILE__;
    }

    public function main(ArticlesInterface $articles): ArticlesInterface
    {
        $articles->map(function ($article) {
            (gettype($article['body']) === 'integer') ? $article['body'] += 1 : $article['body'] = 1;
            (gettype($article['matter']) === 'integer') ? $article['matter'] += 1 : $article['matter'] = 1;
            return $article;
        });

        return $articles;
    }
}