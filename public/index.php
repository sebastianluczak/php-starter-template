<?php

declare(strict_types=1);

namespace App;

include_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Http\ExceptionHandler;
use App\Presentation\Controller\CreateOrder;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

Debug::enable();

$routes = new RouteCollection();
$routes->add('main', new Route(
    path: '/',
    defaults: [
        '_controller' => CreateOrder::class . '::index',
    ],
));

$request = Request::createFromGlobals();
$matcher = new UrlMatcher($routes, new RequestContext());
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));
$dispatcher->addListener('kernel.exception', function (ExceptionEvent $exceptionEvent): void {
    (new ExceptionHandler())->onKernelException($exceptionEvent);
});
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();
$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
