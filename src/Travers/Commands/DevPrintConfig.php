<?php

namespace Travers\Commands;

use Travers\Kernel;
use Travers\CommandWrapper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevPrintConfig extends CommandWrapper
{
    final protected function configure(): void
    {
        $this
            ->setName('dev:print-config')
            ->setDescription('Parse config and pretty-print it');
        parent::configure__config();
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $rules = Kernel::validateConfig($this->option__config_path);

        list($headers, $rows) = $this->prepareTable($rules);
        io()->horizontalTable($headers, $rows);

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