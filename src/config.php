<?php

// The templater function in PHP in < 120 symbols ;)
function templater(string $path, $props): string { extract($props); ob_start(); include $path; return ob_get_clean(); }

return [

    // First rule
    [
        // Set the unique name for rule, so you can identify it
        'name' => 'HTML: Generate blog pages',

        // Stack of middlewares
        'middlewares' => [
            'TestModule1',
            'TestModule2',
        ],

        'handler' => /* Callable|HandlerInterface */ function($articles) {
            echo 'Hello from first rule!';
            dump($articles);
        }
    ],

    // Second rule
    [
        // Set the unique name for rule, so you can identify it
        'name' => 'HTML: Generate index for blog pages',

        // Stack of middlewares
        'middlewares' => [
            'TestModule2',
            ['name' => 'TestModule1', 'options' => 42],
        ],

        'handler' => /* Callable|HandlerInterface */ function($articles) {
            echo 'Hello from second rule!';
            dump($articles);
        }
    ],

    // Other rules
    // ...

];