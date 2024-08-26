<?php

namespace Travers\Middlewares\TestModule2;

use Travers\Interfaces\ArticlesInterface;
use Travers\Interfaces\MiddlewareInterface;
use League\CommonMark\CommonMarkConverter;
use Travers\IO;

// TODO middleware description

class Middleware implements MiddlewareInterface
{
    private CommonMarkConverter $commonmark;

    public function __construct()
    {
        $this->commonmark = new CommonMarkConverter();
    }

    public function setFilePath(): string
    {
        return __FILE__;
    }

    public function main(ArticlesInterface $articles): ArticlesInterface
    {
        IO::text('Hello from TestModule2!');
        IO::text(__FILE__);

        $articles->map(function ($article) {
            $article['body'] = $this->commonmark->convert($article['body'])->getContent();
            return $article;
        });

        //$articles->set($result);

        return $articles;
    }
}