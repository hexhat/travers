<?php

namespace Travers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\ErrorHandler\Debug;

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
            default: __DIR__ . '/../../fixtures/markdown-sources'
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
        $GLOBALS['current_command_i'] = $input;
        $GLOBALS['current_command_o'] = $output;
        $GLOBALS['current_command_io'] = new SymfonyStyle(IO::input(), IO::output());

        // Set SymfonyDebug at max verbosity level
        IO::isDebug() && Debug::enable();

        // Set options, so child commands be able to access it
        if (IO::input()->hasOption('config')) {
            $file = IO::input()->getOption('config');
            if (!is_file($file)) {
                throw new \InvalidArgumentException(
                    "The specified config file '{$file}' does not exist."
                );
            }
            $this->option__config_path = $file;
        }
        if (IO::input()->hasOption('source')) {
            $dir = IO::input()->getOption('source');
            if (!is_dir($dir)) {
                throw new \InvalidArgumentException(
                    "The specified source folder '{$dir}' does not exist."
                );
            }
            $this->option__dir_source_path = $dir;
        }
        if (IO::input()->hasOption('templates')) {
            $dir = IO::input()->getOption('templates');
            /* TODO uncomment later
            if (!is_dir($dir)) {
                throw new \InvalidArgumentException(
                    "The specified templates folder '{$dir}' does not exist."
                );
            }
            */
            $this->option__dir_templates_path = $dir;
        }
        if (IO::input()->hasOption('result')) {
            // TODO verbose: if folder not exists print message
            $this->option__dir_result_path = IO::input()->getOption('result');
        }

        // Return unix status code
        return 0;
    }
}
