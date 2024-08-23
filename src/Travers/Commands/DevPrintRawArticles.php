<?php

namespace Travers\Commands;

use Symfony\Component\Console\Input\InputInterface;
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
        parent::configure__source();
    }
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);
        io()->writeln(
            '<info>' .
            var_export((new Articles($this->option__dir_source_path)), true) .
            '</info>'
        );
        return 0;
    }
}
