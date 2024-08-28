<?php

namespace Travers;

/**
 * A collection of helpers based on Symfony IO.
 * This class operates in the context of the current command.
 *
 * To avoid confusion and inconsistency, public methods should not be used inside each other,
 * instead get() method should be preferred in any cases.
 */

use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class IO
{
    /**
     * Common way to interact with the current command IO streams.
     * @return SymfonyStyle The return object contains
     * SymfonyStyle methods in the current command context.
     *
     * Should not be used explicitly, but rather be wrapped by the explicit public methods.
     */
    static private function get(): SymfonyStyle
    {
        return $GLOBALS['current_command_io'];
    }

    static public function input(): InputInterface
    {
        return $GLOBALS['current_command_i'];
    }

    static public function output(): OutputInterface
    {
        return $GLOBALS['current_command_o'];
    }



    static public function isDebug(): bool
    {
        return self::get()->isDebug();
    }


    /**
     * Print SymfonyStyle->text()
     * @param string $text The text you need to print.
     * @return void
     */
    static public function text(string $text): void
    {
        self::get()->text($text);
    }

    /**
     * Print SymfonyStyle->text() with -v or 1 verbosity level
     * @param string $text The text you need to print.
     * @return void
     */
    static public function textVerbose(string $text): void
    {
        self::get()->isVerbose() && self::get()->text($text);
    }

    /**
     * Print SymfonyStyle->text() with -vv or 2 verbosity level
     * @param string $text The text you need to print.
     * @return void
     */
    static public function textVeryVerbose(string $text): void
    {
        self::get()->isVeryVerbose() && self::get()->text($text);
    }

    /**
     * Print SymfonyStyle->text() with -vvv or 3 verbosity level
     * @param string $text The text you need to print.
     * @return void
     */
    static public function textDebug(string $text): void
    {
        self::get()->isDebug() && self::get()->text($text);
    }



    static public function newLine(int $count = 1): void
    {
        self::get()->newLine($count);
    }

    static public function newLineVerbose(int $count = 1): void
    {
        self::get()->isVerbose() && self::get()->newLine($count);
    }

    static public function newLineVeryVerbose(int $count = 1): void
    {
        self::get()->isVeryVerbose() && self::get()->newLine($count);
    }

    static public function newLineDebug(int $count = 1): void
    {
        self::get()->isDebug() && self::get()->newLine($count);
    }



    static public function definitionList(string|array|TableSeparator ...$list): void
    {
        self::get()->definitionList(...$list);
    }

    static public function definitionListVerbose(string|array|TableSeparator ...$list): void
    {
        self::get()->isVerbose() && self::get()->definitionList($list);
    }

    static public function definitionListVeryVerbose(string|array|TableSeparator ...$list): void
    {
        self::get()->isVeryVerbose() && self::get()->definitionList($list);
    }

    static public function definitionListDebug(string|array|TableSeparator ...$list): void
    {
        self::get()->isDebug() && self::get()->definitionList($list);
    }



    static public function listing(array $elements): void
    {
        self::get()->listing($elements);
    }
    static public function listingVerbose(array $elements): void
    {
        self::get()->isVerbose() && self::get()->listing($elements);
    }
    static public function listingVeryVerbose(array $elements): void
    {
        self::get()->isVeryVerbose() && self::get()->listing($elements);
    }
    static public function listingDebug(array $elements): void
    {
        self::get()->isDebug() && self::get()->listing($elements);
    }



    static public function warning(string|array $message): void
    {
        self::get()->warning($message);
    }



    static public function horizontalTable(array $headers, array $rows): void
    {
        self::get()->horizontalTable($headers, $rows);
    }
}