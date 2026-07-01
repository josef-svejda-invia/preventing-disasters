.PHONY: build install test run shell

build:        ## Build the PHP 8.5 image
	docker compose build

install:      ## Install Composer dependencies
	docker compose run --rm app composer install

test:         ## Run the PHPUnit test suite
	docker compose run --rm app composer test

run:          ## Run the demo entrypoint
	docker compose run --rm app php bin/console.php

shell:        ## Open a shell inside the container
	docker compose run --rm app bash
