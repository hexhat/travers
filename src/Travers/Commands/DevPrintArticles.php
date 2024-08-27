<?php

namespace Travers\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Travers\Articles;
use Travers\CommandWrapper;
use Travers\IO;

#[AsCommand(
    name: 'dev:print-articles',
    description: 'Load <fg=yellow>source</> to the <fg=red>Articles</> object and output',
    aliases: ['dpa'],
    hidden: false
)]
class DevPrintArticles extends CommandWrapper
{
    final protected function configure(): void
    {
        $this->addOption(
            name: 'format',
            shortcut: 'f',
            mode: InputOption::VALUE_REQUIRED,
            description: 'The output format (string, json, pretty)',
            default: 'string'
        );
        parent::configure__source();
    }
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);
        IO::text((new Articles($this->option__dir_source_path)));
        return 0;
    }
}
