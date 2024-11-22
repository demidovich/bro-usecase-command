help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

stan: ## Runs a static analysis with phpstan
	vendor/bin/phpstan analyse src

test: ## Runs tests with phpunit
	vendor/bin/phpunit

vendor: composer.json
	composer validate --strict
	composer install
	composer normalize
