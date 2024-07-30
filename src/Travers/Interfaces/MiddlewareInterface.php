<?php

namespace Travers\Interfaces;

interface MiddlewareInterface
{
    /**
     * This is a good place to init vendor objects.
     * No need for DI, module is representing corresponding vendor library in most cases anyway.
     */
    // public function __construct();

    /**
     * Dynamic middleware loading entry point.
     * @param ArticlesInterface $articles Input Articles object from the Kernel or from an above middleware.
     * @return ArticlesInterface Output mutated Articles object to the Kernel or to a below middleware.
     */
    public function main(ArticlesInterface $articles): ArticlesInterface;
}