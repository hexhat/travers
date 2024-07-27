<?php

namespace Travers\Interfaces;

interface ArticlesInterface extends \Iterator
{
    public function __construct(string $blog_dir);
}