Main origin of the project at [sourcehut](https://git.sr.ht/~hexhat/travers).

---

This is an alpha preview. The skeleton of the project is ready, but many things still need to be done.

Travers is a microframework that allows you to build static websites of any complexity.

It has a rich modular system (middlewares) that mutates your markdown source files. After that, you can do anything you want with them inside a PHP closure (place them in folders, run a templater, etc.).

The config file is very simple. It consists of rules, each rule being a chain of middlewares and a closure as an instruction on how to template your result files.

Travers has only one hardcoded rule: the source folder is flat and contains markdown files with YAML frontmatter.

## Requirements
- Composer
- Latest stable PHP available


## How to get started?
```shell
git clone https://github.com/hexhat/travers.git
cd travers

# Run dependency install of PHP, Middlewares & Handlers
composer install

# Options are described in the help pages
./bin/travers
```

## Currently working at:
- Clean .gitignore
- Fix all TODOs
- Add middleware wrapper for extend
- Add config pretty-print
- Add facade for closure inside `Articles` object
- Configure `dev:` namespace
  - Add rest of the dev commands
- Add global post-install after all rules
- Add `dev` config for parcel rules
- Default feature-rich template
- Implement documentation of middleware config (reflection)
- Previous `Articles` versions array
- Enable Symfony Debug at debug verbosity level
- Tests
  - Local middleware tests
  - Refactoring for tests
  - Coverage report
  - GitHub Actions
    - Static analysis
    - Linter
  - Fixtures data
    - Tutorial fixture
- Handler as class; the whole conception is underdeveloped
- Middlewares:
  - CommonMark
  - MathJax
- Refactoring of internals
  - Refactor `Articles` workflow
- Node integration
- Add more verbose/debug info
- Add optional flag for user's middlewares folder
- Readme
  - Documentation
  - DocBlocks coverage
- Arch Linux PKGBUILD rule
  - Completion script
- Docker build rule
  - Completion script
- Create a logo
- Draw a flow scheme
- Ideas (or tasks after `v1.0.0` release)
  - Add [changelog](https://keepachangelog.com/en/1.1.0/)
  - Experimental `*` branch
    - Add it to readme
    - Create CI for it
  - Middleware dependencies system
  - Array of middleware's advisable closures stack
  - Add the ability to expose config/modules to user's folder
    - Old tests must be fully compatible without changes
  - Add Middleware template command (+gitignore)
  - Add Handler template command (+gitignore)
  - Add support for grabbing files only with specific YAML frontmatter key-value
  - Add Command template command
