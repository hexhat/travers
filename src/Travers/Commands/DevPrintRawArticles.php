<?php

namespace Travers\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Travers\Articles;
use Travers\CommandWrapper;

class DevPrintRawArticles extends CommandWrapper
{
    final protected function configure(): void
    {
        $this
            ->setName('dev:print-raw-articles')
            ->setDescription('Dump raw <fg=yellow>Articles</> object');
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
        io()->text((new Articles($this->option__dir_source_path)));
        return 0;
    }
}
