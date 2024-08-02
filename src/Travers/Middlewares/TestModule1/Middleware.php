<?php

namespace Travers\Middlewares\TestModule1;

use Travers\Interfaces\ArticlesInterface;
use Travers\Interfaces\MiddlewareInterface;


class Middleware implements MiddlewareInterface
{
    public function __construct() { }

    public function setFilePath(): string
    {
        return __FILE__;
    }

    public function main(ArticlesInterface $articles): ArticlesInterface
    {
        $result = [];
        foreach ($articles as $path => $article) {
            $result[$path] = [
                'matter' => $article['matter'],
                'body' => $article['body']
            ];
            $result[$path]['matter']['TestModule1'] = 'Hello!';
        }

        $articles->set($result);

        return $articles;
    }
}