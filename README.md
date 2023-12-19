# PHP 8.3 Startup Template

This is a template for modern web projects based on PHP 8.3 and Symfony components.

Provides pre-setup environment for Minikube with PHP project configured with latest PHP code quality tools.

## Infrastructure

Created as IaC, makes use of local Minikube instance.
All k8s definitions are located in `.infra` directory.

You can build and use images on your own, there's simple `compose.yml` file for Docker provided.

## Code quality tools

Configured are:
- custom rules for PHP-CS-Fixer following latest PER-CS,
- PSR12 rules for PHP_CS,
- PHP-MessDetector with all rules enabled,
- PHPStan on level 9,
- PHPArkitect with basic architecture setup,
- PHP Rector with simple configuration and ruleset for PHP 8.3,
- Pest Unit Tests configured with code coverage reports

## Code

There's simple code provided in `./src` directory and simple Pest tests in `./tests`.

This code follows all standards configured, you may review it for your liking.

You can remove it and start from scratch with your own solution.

## Setup

You need to have [Minikube](https://minikube.sigs.k8s.io/docs/start/) installed on your local machine as this project utilizes kubernetes IaC definitions.

After installing Minikube clone this repository and run:

```shell
$ make start && make build && make deploy && make install && make checks
```

Above will:
- start `minikube` kubernetes cluster,
- build nginx and php images from Dockerfiles in `.infra/` directory,
- upload build images to cluster,
- deploy infrastructure to cluster,
- install `vendor` dependencies from `composer.json`,
- run all code quality tools

See `make help` for more information.
