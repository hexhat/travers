<?php

namespace Travers\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Travers\Articles;
use Travers\IO;
use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'dev:build-dummy',
    description: 'Run building loop on a single <fg=yellow>DummyMiddleware</>',
    aliases: ['dbd'],
    hidden: false
)]
class DevBuildDummy extends CommandWrapper
{
    final protected function configure(): void
    {
        parent::configure__source();
        parent::configure__format();
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $initial_articles_object = new Articles($this->option__dir_source_path);

        $rules = [
            [
                'name' => 'body += 3',
                'middlewares' => [
                    'DummyMiddleware',
                    'DummyMiddleware',
                    'DummyMiddleware'
                ],
                'handler' => function($articles) {
                    IO::textVerbose('Message from the first handler');
                    IO::textDebug($articles);
                }
            ],
            [
                'name' => 'body += 2',
                'middlewares' => [
                    'DummyMiddleware',
                    'DummyMiddleware'
                ],
                'handler' => function($articles) {
                    IO::textVerbose('Message from the second handler');
                    IO::textDebug($articles);
                }
            ],
        ];

        foreach ($rules as $rule) {
            $articles = Kernel::runMiddlewaresChain($initial_articles_object, $rule['middlewares']);
            $rule['handler']($articles);
        }

        IO::text($articles);

        return 0;
    }
}