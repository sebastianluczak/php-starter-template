# Executables
DOCKER   = docker
MINIKUBE = minikube
KUBECTL  = kubectl

# Versions of internal docker images. Bump them on each infra change.
PHP_FPM_VERSION = "1.3"
NGINX_VERSION = "1.1"

# Misc
EXEC_ON_PHP   = kubectl exec deployments/web -c application -it --
.DEFAULT_GOAL = help
.PHONY        = help

## —— 🕸️ kubernetes > 🚀 Deployments ——————————————————————————————————
deploy: ## Deploys infrastructure
	@echo "\033[1;32m🍺 Deploying infrastructure, please wait...\033[0m"
	@$(eval c=apply -f ./.infra/k8s/dev)
	@$(KUBECTL) $(c)
	@echo "\033[2;32m🦄 Deployment ready, happy coding.\033[0m"

destroy: ## Destroys infrastructure
	@echo "\033[1;31m🍺 Destroying infrastructure, please wait...\033[0m"
	@$(eval c=delete -f ./.infra/k8s/dev)
	@$(KUBECTL) $(c)
	@echo "\033[2;31m🦄 Infrastructure destroyed, cluster clear.\033[0m"

## —— 🕸️ kubernetes > 🐱‍💻 Local Environment —————————————————————————
start: ## Starts local environment
	@echo "\033[1;32m🍺 Starting minikube cluster...\033[0m"
	@$(eval c=start --cpus=no-limit --memory=no-limit --mount --mount-string="./:/src")
	@$(MINIKUBE) $(c)
	@echo "\033[2;32m🦄 Cluster ready, fire away.\033[0m"

shell: ## Starts ssh shell
	@echo "\033[2;32m🍺 Executing shell inside PHP container...\033[0m"
	@$(KUBECTL) exec -it deployments/web -c application -- bash

## —— 🕸️ kubernetes > 🐋 Docker Images ————————————————————————————————
build: ## Builds all required docker images
	@echo "\033[1;32m🛠️ Building PHP-FPM image in version $(PHP_FPM_VERSION). Please wait...\033[0m"
	@$(eval c=build -f ./.infra/dockerfiles/php-fpm/Dockerfile -t dev-php-fpm:$(PHP_FPM_VERSION) .)
	@$(DOCKER) $(c)
	@echo "\033[1;32m🍺 PHP-FPM image brewed. Uploading to cluster. This may take a while...\033[0m"
	@$(eval c=image load dev-php-fpm:$(PHP_FPM_VERSION))
	@$(MINIKUBE) $(c)
	@echo "\033[2;32m🦄 PHP-FPM image uploaded to cluster."
	@echo "\033[1;32m🛠️ Building Nginx image in version $(NGINX_VERSION). Please wait...\033[0m"
	@$(eval c=build -f ./.infra/dockerfiles/nginx/Dockerfile -t dev-nginx:$(NGINX_VERSION) .)
	@$(DOCKER) $(c)
	@echo "\033[1;32m🍺 Nginx image brewed. Uploading to cluster. This may take a while...\033[0m"
	@$(eval c=image load dev-nginx:$(NGINX_VERSION))
	@$(MINIKUBE) $(c)
	@echo "\033[2;32m🦄 Nginx image uploaded to cluster."

list: ## Lists docker images in cluster
	@$(eval c=image list)
	@$(MINIKUBE) $(c) | grep dev

## —— 💻 Application > 🦄 Codebase ————————————————————————————————————
test: fix checks fix-permissions ## Run all tests

install: ## Installs project
	@echo "\033[1;32m🍺 Running install script, please wait.\033[0m"
	@$(EXEC_ON_PHP) composer install
	@echo "\033[2;32m🦄 Application installed.\033[0m"

checks: ## Fires all code tests and checks
	@$(eval cphpmd=./vendor/bin/phpmd src/ ansi .phpmd.ruleset.xml -vv --color)
	@$(eval cphpstan=./vendor/bin/phpstan analyse -c .phpstan.neon)
	@$(eval cpest=env XDEBUG_MODE=coverage ./vendor/bin/pest --coverage)
	@$(eval carkitect=./vendor/bin/phparkitect check)
	@$(eval cypecheck=./vendor/bin/pest --type-coverage)
	@$(eval csecurityscan=./vendor/bin/security-checker security:check ./composer.lock)
	@echo "\033[1;32m🍺 Running Mess Detector.\033[0m"
	@$(EXEC_ON_PHP) $(cphpmd)
	@echo "\033[1;32m🍺 Running PHPStan.\033[0m"
	@$(EXEC_ON_PHP) $(cphpstan)
	@echo "\033[1;32m🍺 Running Unit Tests.\033[0m"
	@$(EXEC_ON_PHP) $(cpest)
	@echo "\033[1;32m🍺 Running PHPArkitect.\033[0m"
	@$(EXEC_ON_PHP) $(carkitect)
	@echo "\033[1;32m🍺 Running Strict Type checks.\033[0m"
	@$(EXEC_ON_PHP) $(cypecheck)
	@echo "\033[1;32m🍺 Running Security scan.\033[0m"
	@$(EXEC_ON_PHP) $(csecurityscan)

fix: ## Runs linter against ./src and ./tests
	@$(eval crector=./vendor/bin/rector)
	@$(eval cphpcsfix=./vendor/bin/php-cs-fixer fix --diff --verbose)
	@$(eval cphpcodestyle=./vendor/bin/phpcs --report=full -p -s)
	@echo "\033[1;32m🍺 Running PHP Rector check.\033[0m"
	@$(EXEC_ON_PHP) $(crector)
	@echo "\033[1;32m🍺 Running PHP-CS-Fixer fix.\033[0m"
	@$(EXEC_ON_PHP) $(cphpcsfix)
	@echo "\033[1;32m🍺 Running PHP Code Style check.\033[0m"
	@$(EXEC_ON_PHP) $(cphpcodestyle)

## —— 🎵 Help Section —————————————————————————————————————————————————
fix-permissions: ## Fixes docker permissions
	@$(EXEC_ON_PHP) chown 1000:1000 -R /app

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'