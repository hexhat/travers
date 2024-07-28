<?php

namespace Travers\Middlewares\TestModule2;

use Travers\Interfaces\ArticlesInterface;
use Travers\Interfaces\MiddlewareInterface;
use League\CommonMark\CommonMarkConverter;

// TODO middleware description

class Middleware implements MiddlewareInterface
{
    private CommonMarkConverter $commonmark;

    public function __construct()
    {
        $this->commonmark = new CommonMarkConverter();
    }

    public function main(ArticlesInterface $articles): ArticlesInterface
    {
        text('Hello from TestModule2!');
        text(__FILE__);

        $articles->mapBody(function ($article) {
            $article['body'] = $this->commonmark->convert($article['body'])->getContent();
            return $article;
        });

        //$articles->set($result);

        return $articles;
    }
}