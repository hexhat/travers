<?php

namespace Travers\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Travers\Articles;
use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'build',
    description: 'Run main building loop process',
    hidden: false
)]
class Build extends CommandWrapper
{
    final protected function configure(): void
    {
        parent::configure__config();
        parent::configure__source();
        parent::configure__templates();
        parent::configure__result();
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $initial_articles_object = new Articles($this->option__dir_source_path);
        $rules = Kernel::validateConfig($this->option__config_path);

        foreach ($rules as $rule) {
            $articles = Kernel::runMiddlewaresChain($initial_articles_object, $rule['middlewares']);
            $rule['handler']($articles);
        }

        return 0;
    }
}