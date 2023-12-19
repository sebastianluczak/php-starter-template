<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\DependsOnlyOnTheseNamespaces;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\IsFinal;
use Arkitect\Expression\ForClasses\IsNotAbstract;
use Arkitect\Expression\ForClasses\NotDependsOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $classSet = ClassSet::fromDir(__DIR__.'/src');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App'))
        ->should(new IsFinal())
        ->because('all classes should be final by default');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Presentation\Controller'))
        ->should(new HaveNameMatching('*Controller'))
        ->because('controller classes should be named accordingly.');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Domain'))
        ->should(new IsFinal())
        ->because('all domain classes should be final.');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Domain'))
        ->should(new NotHaveDependencyOutsideNamespace(
            'App\Domain',
            ['Ramsey\Uuid', 'Random\Randomizer', 'Exception', 'DateTimeImmutable'])
        )
        ->because('we want protect our domain except for Ramsey\Uuid and Random\Randomizer');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Domain'))
        ->should(new IsNotAbstract())
        ->because('we want to avoid abstract classes into our domain');

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Application'))
        ->should(new DependsOnlyOnTheseNamespaces('App\Application', 'App\Domain'))
        ->because('we want that application depends only on itself and domain namespace.');;

    $domainRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Application'))
        ->should(new NotDependsOnTheseNamespaces('App\Infrastructure'))
        ->because('we want to avoid coupling between application layer and infrastructure layer');

    $config->add($classSet, ...$domainRules);
};
