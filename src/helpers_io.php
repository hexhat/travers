<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Common way to interact with current command's $io.
 * @return SymfonyStyle The return object contains
 * SymfonyStyle methods in current command's context.
 */
function io(): SymfonyStyle
{
    return $GLOBALS['current_command_io'];
}
function input(): InputInterface
{
    return $GLOBALS['current_command_i'];
}
function output(): InputInterface
{
    return $GLOBALS['current_command_o'];
}
/**
 * Print SymfonyStyle->text()
 * @param string $text The text you need to print.
 * @return void
 */
function text(string $text): void
{
    io()->text($text);
}
/**
 * Print SymfonyStyle->text() with -v or 1 verbosity level
 * @param string $text The text you need to print.
 * @return void
 */
function textVerbose(string $text): void
{
    io()->isVerbose() && io()->text($text);
}
/**
 * Print SymfonyStyle->text() with -vv or 2 verbosity level
 * @param string $text The text you need to print.
 * @return void
 */
function textVeryVerbose(string $text): void
{
    io()->isVeryVerbose() && io()->text($text);
}
/**
 * Print SymfonyStyle->text() with -vvv or 3 verbosity level
 * @param string $text The text you need to print.
 * @return void
 */
function textDebug(string $text): void
{
    io()->isDebug() && io()->text($text);
}
/**
 * Dump the entity with -vvv or 3 verbosity level.
 * @param mixed $value The entity you need to dump.
 * @param string $prefix Optional prefix.
 * @return void
 */
function dumpDebug(mixed $value, string $prefix = ''): void
{
    !empty($prefix) && $prefix .= ': ';
    io()->isDebug() && print_r($prefix) && dump($value);
}