<?php

namespace Travers\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Travers\IO;
use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// TODO do [string, json, pretty] formats

#[AsCommand(
    name: 'dev:print-config',
    description: 'Parse <fg=yellow>config</> and output',
    aliases: ['dpc'],
    hidden: false
)]
class DevPrintConfig extends CommandWrapper
{
    final protected function configure(): void
    {
        parent::configure__config();
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $rules = Kernel::validateConfig($this->option__config_path);

        list($headers, $rows) = $this->prepareTable($rules);
        IO::horizontalTable($headers, $rows);

        return 0;
    }

    final protected function prepareTable(array $data): array
    {
        $names = array_map(fn($item) => $item['name'], $data);
        $middlewares = array_map(fn($item) => $item['middlewares'], $data);

        $max_length = max(array_map('count', $middlewares));

        $result = [$names, []];
        for ($i = 0; $i < $max_length; $i++) {
            $temp = [];
            foreach ($middlewares as $middleware) {
                if (isset($middleware[$i])) {
                    $temp[] = is_array($middleware[$i]) ? $middleware[$i]['name'] : $middleware[$i];
                } else {
                    $temp[] = '';
                }
            }
            $result[1][] = $temp;
        }

        return $result;
    }
}