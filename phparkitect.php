<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $classSet = ClassSet::fromDir(__DIR__.'/src');

    $finalRule = Rule::allClasses()
        ->that(new \Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces('BDev\Foo'))
        ->should(new \Arkitect\Expression\ForClasses\IsFinal())
        ->because('all classes should be final by default');

    $config->add(
        classSet: $classSet,
        rules: $finalRule
    );
};
