<?php

namespace Travers\Commands;

use Travers\Articles;
use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevRunMiddleware extends CommandWrapper
{
    final protected function configure(): void
    {
        $this
            ->setName('dev:run-middleware')
            ->setDescription('Run & dump single middleware');

        $this->addOption(
            name: 'middleware',
            shortcut: 'm',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Middleware name',
            default: 'DummyMiddleware'
        );

        parent::configure__source();
        parent::configure__templates();
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $initial_articles_object = new Articles($this->option__dir_source_path);

        $option = $input->getOption('middleware');

        dump(Kernel::runMiddlewaresChain($initial_articles_object, [$option]));

        return 0;
    }
}
