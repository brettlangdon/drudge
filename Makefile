default: install

clean:
	@rm -rf vendor
	@rm composer.lock

install:
	composer install

run:
	./bin/drudge $(ARGS)

.PHONY: clean install default
