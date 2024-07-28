<?php

/**
 * At any Articles object iteration you have the following options:
 * - Set it back, using set() method
 * - Iterate over it using foreach - this will create a copy, not a reference, so you will need to set() its copy
 * - Iterate over body using mapBody
 * - Grab it directly using get() method
 * - Print the object to get JSON string - can be useful in the closure/handler
 */

namespace Travers;

use Spatie\YamlFrontMatter\YamlFrontMatter;
use Travers\Interfaces\ArticlesInterface;
use TypeError;

class Articles implements ArticlesInterface
{
    /**
     * @var array|int[]|string[] Keys for the \Iterator methods.
     */
    private array $keys;
    /**
     * @var int Position for the \Iterator methods.
     */
    private int $position = 0;
    /**
     * @var string Path to the markdown articles folder.
     */
    private string $dir;
    /**
     * @var array Articles storage.
     */
    private array $articles;

    /**
     * @var bool True if $this->articles[$path] have more than two items [matter, body].
     */
    private bool $is_articles_extended = false;

    /**
     * @param string $blog_dir
     */
    public function __construct(string $blog_dir)
    {
        $this->dir = getFirstValidPath($blog_dir);
        $this->articles = $this->fsLoadArticles(scandir($this->dir));
        $this->keys = array_keys($this->articles);
    }

    public function __toString(): string
    {
        return json_encode($this->articles);
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current(): mixed
    {
        $key = $this->keys[$this->position];
        return $this->articles[$key];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed|null TKey on success, or null on failure.
     */
    public function key(): mixed
    {
        return $this->keys[$this->position];
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be cast to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return isset($this->keys[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @param array $files The scandir() array.
     * @return array Return array of articles and its frontmatters.
     * @key Key of the array is full filepath to the article.
     */
    private function fsLoadArticles(array $files): array
    {
        $md_files = array_filter($files, function($file) {
            $is_file = is_file($this->dir . '/' . $file);
            $is_md = pathinfo($this->dir . '/' . $file, PATHINFO_EXTENSION) === 'md';
            return $is_file && $is_md;
        });

        text('Loading files from your markdown vault');
        io()->progressStart(count($md_files));

        $result = array_map(function($file) {
            $file_path = $this->dir . '/' . $file;
            $file_content = file_get_contents($file_path);
            $parsed = YamlFrontMatter::parse($file_content);

            io()->progressAdvance();

            return [
                'matter' => $parsed->matter(),
                'body' => $parsed->body()
            ];
        }, $md_files);

        io()->progressFinish();

        return array_combine(array_map(function($file) {
            return $this->dir . '/' . $file;
        }, $md_files), $result);
    }

    public function mapBody(callable $callback): void
    {
        foreach ($this->keys as $key) {
            $this->articles[$key] = $callback($this->articles[$key]);
        }
    }

    /**
     * Can be helpful if you need to access some of the files from middleware or handler
     * that are not part of the Articles object by default.
     * @return string Your blog's source files (articles)
     */
    public function getSourceDir(): string
    {
        return $this->dir;
    }

    /**
     * Can be helpful to find out that structure isn't default.
     * @return bool True if the structure have more than two items [matter, body].
     */
    public function isArticlesExtended(): bool
    {
        return $this->is_articles_extended;
    }

    /**
     * Better to iterate over the object itself, but if you need getter - here it is.
     * @return array Returns the main articles array.
     */
    public function get(): array
    {
        return $this->articles;
    }

    public function set(array $articles): void
    {
        foreach ($articles as $article) {
            if (!array_key_exists('matter', $article)) {
                throw new TypeError('"matter" key not found');
            }
            if (!array_key_exists('body', $article)) {
                throw new TypeError('"body" key not found');
            }
            if (count($article) > 2) {
                $this->is_articles_extended = true;
                textDebug('Setting articles extended flag');
            }
        }
        $this->articles = $articles;
        textDebug('Articles array has been set');
    }
}
