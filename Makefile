DIRS := ./src/Travers/Middlewares/* ./src/Travers/Handlers/*

linter-psr2:
	@phpcs --standard=PSR2 .

linter:
	@phpcs .

test:
	@./vendor/bin/pest

all: init

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
