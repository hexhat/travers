<?php

namespace Travers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class CommandWrapper extends Command
{
    public string $option__config_path;
    public string $option__dir_source_path;
    public string $option__dir_templates_path;
    public string $option__dir_result_path;

    /**
     * This should be parented at the end of each Command that interacts with the config.
     * @return void
     */
    protected function configure__config(): void
    {
        $this->addOption(
            name: 'config',
            shortcut: 'c',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Path to config',
            default: __DIR__ . '/../config.php'
        );
    }

    protected function configure__source(): void
    {
        $this->addOption(
            name: 'source',
            shortcut: 's',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Path to markdown source dir',
            default: getenv('HOME') . '/obsidian/blog'
        );
    }

    protected function configure__templates(): void
    {
        $this->addOption(
            name: 'templates',
            shortcut: 't',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Path to templates dir',
            default: (getenv('XDG_DATA_HOME') ?? getenv('HOME') . '/.local/share') . '/travers/templates'
        );
    }

    protected function configure__result(): void
    {
        $this->addOption(
            name: 'result',
            shortcut: 'r',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Path to result dir',
            default: (getenv('XDG_DATA_HOME') ?? getenv('HOME') . '/.local/share') . '/travers/result/' . time()
        );
    }

    /**
     * Add current command's io states to the global helpers.
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Send current command's IO to global helpers
        $GLOBALS['current_command_io'] = new SymfonyStyle($input, $output);
        $GLOBALS['current_command_i'] = $input;
        $GLOBALS['current_command_o'] = $output;

        // Set options, so child commands be able to access it
        if ($input->hasOption('config')) {
            $this->option__config_path = $input->getOption('config');
        }
        if ($input->hasOption('source')) {
            $this->option__dir_source_path = $input->getOption('source');
        }
        if ($input->hasOption('templates')) {
            $this->option__dir_templates_path = $input->getOption('templates');
        }
        if ($input->hasOption('result')) {
            $this->option__dir_result_path = $input->getOption('result');
        }

        // Unix status code
        return 0;
    }
}