> **Project development and tickets are hosted at [sourcehut](https://git.sr.ht/~hexhat/travers).**

This is an alpha preview. The skeleton of the project is ready, but many things still need to be done.

Travers is a microframework that allows you to build static websites of any complexity.

It has a rich modular system (middlewares) that mutates your markdown source files. After that, you can do anything you want with them inside a PHP closure (place them in folders, run a templater, etc.).

The config file is very simple. It consists of rules, each rule being a chain of middlewares and a closure as an instruction on how to template your result files.

Travers has only one hardcoded rule: the source folder is flat and contains markdown files with YAML frontmatter.

## Requirements
- Composer
- Latest stable PHP available
- Some middlewares require Node/NPM


## How to get started?
```shell
git clone https://github.com/hexhat/travers.git
cd travers

# Run dependency install of PHP, Middlewares & Handlers
composer install

# Options are described in the help pages
./bin/travers
```
