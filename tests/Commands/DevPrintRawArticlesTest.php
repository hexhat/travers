<?php

use Symfony\Component\Console\Tester\CommandTester;
use Travers\Commands\DevPrintRawArticles;

describe('Command <fg=yellow>dev:print-raw-articles</>:', function () {
    $application = null;
    $commandTester = null;

    beforeEach(function () use (&$application, &$commandTester) {
        $application = initApp(appVersion());
        $application->add(new DevPrintRawArticles());
        $command = $application->find('dev:print-raw-articles');
        $commandTester = new CommandTester($command);
    });

    test('should return success status code', function () use (&$commandTester) {
        $commandTester->execute([]);

        expect($commandTester->getStatusCode())->toBe(0);
    });

    test('should exist fields for the iterator', function () use (&$commandTester) {
        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        expect($output)->toContain("'keys' =>");
        expect($output)->toContain("'position' => 0");
        expect($output)->not()->toContain("'position' => 1");
    });

    test('should contain markdown', function () use (&$commandTester) {
        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        expect($output)->toContain('Powers platforms like WordPress, Joomla, and Drupal.');
        expect($output)->not()->toContain('Powers platforms like Joomla, WordPress, and Drupal.');

        expect($output)->toContain('- **Content Management Systems _(CMS)_**:');
        expect($output)->not()->toContain('- **Content Management Systems _(SMC)_**:');
    });

    test('should contain frontmatter', function () use (&$commandTester) {
        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        expect($output)->toContain("'set_slug' => 'php-and-beyond'");
        expect($output)->not()->toContain("'set_slug' => 'beyond-php'");
    });

    test('should contain correct path in the key', function () use (&$commandTester) {
        $commandTester->execute([]);
        $output = $commandTester->getDisplay();

        expect($output)->toContain("ces/Composer and Git.md' =>");
        expect($output)->not()->toContain("ces/Git and Composer.md' =>");
    });
});
