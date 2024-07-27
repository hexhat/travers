<?php

namespace Travers\Commands;

use Travers\Articles;
use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends CommandWrapper
{
    final protected function configure(): void
    {
        $this
            ->setName('build')
            ->setDescription('Run main building loop process');
        parent::configure_config();
        parent::configure_source();
        parent::configure_templates();
        parent::configure_result();
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