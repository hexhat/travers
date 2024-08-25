<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Travers\Commands\DevPrintRawArticles;

describe('<fg=yellow>dev:print-raw-articles --format=string</>:', function () {
    $application = null;
    $command_tester = null;

    beforeEach(function () use (&$application, &$command_tester) {
        $application = initApp(appVersion());
        $application->add(new DevPrintRawArticles());
        $command = $application->find('dev:print-raw-articles');
        $command_tester = new CommandTester($command);
    });

    test('should return success status code', function () use (&$command_tester) {
        $command_tester->execute([]);

        expect($command_tester->getStatusCode())->toBe(0);
    });

    test('iterator fields should be present', function () use (&$command_tester) {
        $command_tester->execute([]);
        $output = $command_tester->getDisplay();

        expect($output)->toContain("'keys' =>");
        expect($output)->toContain("'position' => 0");
        expect($output)->not()->toContain("'position' => 1");
    });

    test('should contain markdown', function () use (&$command_tester) {
        $command_tester->execute([]);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('Powers platforms like WordPress, Joomla, and Drupal.');
        expect($output)->not()->toContain('Powers platforms like Joomla, WordPress, and Drupal.');

        expect($output)->toContain('- **Content Management Systems _(CMS)_**:');
        expect($output)->not()->toContain('- **Content Management Systems _(SMC)_**:');
    });

    test('should contain frontmatter', function () use (&$command_tester) {
        $command_tester->execute([]);
        $output = $command_tester->getDisplay();

        expect($output)->toContain("'set_slug' => 'php-and-beyond'");
        expect($output)->not()->toContain("'set_slug' => 'beyond-php'");
    });

    test('should contain correct path in the key', function () use (&$command_tester) {
        $command_tester->execute([]);
        $output = $command_tester->getDisplay();

        expect($output)->toContain("ces/Composer and Git.md' =>");
        expect($output)->not()->toContain("ces/Git and Composer.md' =>");
    });
});

describe('<fg=yellow>dev:print-raw-articles --format=json</>:', function () {
    $application = null;
    $command_tester = null;
    $opts = ['--format' => 'json'];

    beforeEach(function () use (&$application, &$command_tester) {
        $application = initApp(appVersion());
        $application->add(new DevPrintRawArticles());
        $command = $application->find('dev:print-raw-articles');
        $command_tester = new CommandTester($command);
    });

    test('should return success status code', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);

        expect($command_tester->getStatusCode())->toBe(0);
    });

    test('should contain markdown', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('Powers platforms like WordPress, Joomla, and Drupal.');
        expect($output)->not()->toContain('Powers platforms like Joomla, WordPress, and Drupal.');

        expect($output)->toContain('- **Content Management Systems _(CMS)_**:');
        expect($output)->not()->toContain('- **Content Management Systems _(SMC)_**:');
    });

    test('should contain frontmatter', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('"set_slug":"php-and-beyond"');
        expect($output)->not()->toContain('"set_slug":"beyond-php"');
    });

    test('should contain correct path in the key', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('About Nature.md":{');
        expect($output)->not()->toContain('Not About Nature.md":{');
    });
});

describe('<fg=yellow>dev:print-raw-articles --format=pretty</>:', function () {
    $application = null;
    $command_tester = null;
    $opts = ['--format' => 'pretty'];

    beforeEach(function () use (&$application, &$command_tester) {
        $application = initApp(appVersion());
        $application->add(new DevPrintRawArticles());
        $command = $application->find('dev:print-raw-articles');
        $command_tester = new CommandTester($command);
    });

    test('should return success status code', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('Exiting pretty print');
        expect($command_tester->getStatusCode())->toBe(0);
    });

    test('should contain markdown', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('Content preview: **PHP**, or **Hypertext Preprocessor**');
        expect($output)->not()->toContain('Content preview: **PHP**, or **Personal Home Page**');
    });


    test('should contain frontmatter', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('["git","composer","programming","php"]');
        expect($output)->not()->toContain('["svn","npm","programming","js"]');

        expect($output)->toContain('1721779200');
        expect($output)->not()->toContain('2001721779');
    });
});

describe('<fg=yellow>dev:print-raw-articles --format=pretty -v</>:', function () {
    $application = null;
    $command_tester = null;
    $opts = ['--format' => 'pretty'];

    beforeEach(function () use (&$application, &$command_tester) {
        $application = initApp(appVersion());
        $application->add(new DevPrintRawArticles());
        $command = $application->find('dev:print-raw-articles');
        $command_tester = new CommandTester($command);
    });

    test('should display iterator keys', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts, ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);
        $output = $command_tester->getDisplay();

        expect($output)->toMatch('/Iterator keys\n \* \/.*\/fixtures\/markdown-sources.*/');
    });

    test('should display iterator position', function () use ($opts, &$command_tester) {
        $command_tester->execute($opts, ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);
        $output = $command_tester->getDisplay();

        expect($output)->toContain('Start iterator position is 0');
        expect($output)->toContain('Current iterator position is 0');
        expect($output)->toContain('Current iterator position is 1');
        expect($output)->toContain('Current iterator position is 2');
        expect($output)->toContain('End iterator position is 3');
    });
});
