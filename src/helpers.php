<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

function makeCopy(object $object)
{
    return $GLOBALS['copier']->copy($object);
}

function templateRender(string $path, $props): string
{
    extract($props);
    ob_start();
    include $path;
    return ob_get_clean();
}

function getFirstValidPath(array|string $paths): string
{
    dumpDebug($paths, 'Path list');

    if (empty($paths)) {
        throw new InvalidArgumentException("The paths array must contain at least one item");
    }

    if (gettype($paths) === 'string') {
        $paths = [$paths];
    }

    foreach ($paths as $path) {
        if (file_exists($path)) {
            io()->text('Found: ' . $path);
            return $path;
        }
        io()->text($path . ': is not found, trying next...');
    }

    throw new RuntimeException("None of the provided paths are valid files or directories.");
}