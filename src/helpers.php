<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Travers\Interfaces\ArticlesInterface;

// TODO remove?
function loadModules(array $modules, ArticlesInterface $initial_articles_object): iterable {
    $waste_objects = [];
    $articles[] = $initial_articles_object;

    foreach ($modules as $module) {
        if (class_exists($module)) {
            $waste_objects[] = new $module();
            $articles[] = end($waste_objects)->clone(end($articles), $articles);
        } else {
            throw new InvalidArgumentException("Module class $module does not exist");
        }
    }

    return $articles;
}

function makeCopy(object $object)
{
    return $GLOBALS['copier']->copy($object);
}

// TODO send templater in a polymorphic way through parameter
function templateRender(string $path, $props): string
{
    extract($props);
    ob_start();
    include $path;
    return ob_get_clean();
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
            if ($reflector->isInstantiable() && $reflector->isSubclassOf('Symfony\Component\Console\Command\Command')) {
                $app->add(new $className());
            }
        }
    }
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