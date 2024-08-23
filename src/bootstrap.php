<?php

/*
 * This file contains helper functions for bootstrap process.
 * It operates outside Application context, so io() operations are not possible.
 */

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

function appVersion(string $path = (__DIR__ . '/../.version')): string
{
    return fgets(fopen($path, 'r'));
}

function initApp(string $version): Application
{
    return new Application('Travers | 🏇 |', $version);
}

function registerCommands(Application $app, string $commands_dir): void
{
    $finder = new Finder();
    $finder->files()->in($commands_dir)->name('*.php');

    foreach ($finder as $file) {
        $relativePath = $file->getRelativePathname();
        $className = 'Travers\\Commands\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            $reflector = new ReflectionClass($className);
            if ($reflector->isInstantiable() && $reflector->isSubclassOf('Travers\CommandWrapper')) {
                $app->add(new $className());
            }
        }
    }
}
