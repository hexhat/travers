.PHONY: init tests linter pkgbuild clean push-all-remotes-and-tags

DIRS := ./src/Travers/Middlewares/*

linter-psr2:
	@phpcs --standard=PSR2 .

linter:
	@phpcs .

tests:
	@./vendor/bin/pest

init:
	@for dir in $(DIRS); do \
		if [ -d $$dir ]; then \
			if [ -f $$dir/Makefile ]; then \
				echo "Running 'make init' in $$dir"; \
				$(MAKE) -C $$dir init; \
			else \
				echo "Skipping $$dir as it does not contain a Makefile"; \
			fi \
		fi \
	done

pkgbuild:
	echo 'arch linux build system' # TODO


clean:
	echo 'clean vendor/npm folders' # TODO

push-all-remotes-and-tags:
	@for remote in $$(git remote); do \
		git push $$remote --all; \
		git push $$remote --tags; \
	done