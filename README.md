# PHP 8.3 Startup Template

This is template for new projects in PHP 8.3.

Provides `dev` composer.json with setup code quality tools.

## Infrastructure

Setup as IaC, makes use of local minikube instance.
All k8s definitions are located in `.infra` directory.

## Code

There's no code besides:
- HTTP Symfony Kernel front controller in `index.php`
- JSON Controller in `src/Controller.php`
- Pest unit tests in `tests/Unit/ControllerTest.php`

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