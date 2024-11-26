help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

stan: ## Runs a static analysis with phpstan
	vendor/bin/phpstan analyse src

test: ## Runs tests with phpunit
	XDEBUG_MODE=coverage vendor/bin/phpunit --display-phpunit-deprecations

coverage: ## Runs coverage tests
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text --display-phpunit-deprecations

vendor: composer.json
	composer validate --strict
	composer install
	composer normalize
