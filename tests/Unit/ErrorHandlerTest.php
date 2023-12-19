<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Infrastructure\Http;

use App\Infrastructure\Http\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

it('returns json for exceptions.', function () {
    $content = (string)json_encode(['products' => []]);
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
        content: $content,
    );

    $kernel = \Mockery::mock(HttpKernelInterface::class);

    $exceptionEvent = new ExceptionEvent(
        kernel: $kernel,
        request: $request,
        requestType: HttpKernelInterface::MAIN_REQUEST,
        e: new \Exception('test_exception'),
        isKernelTerminating: false,
    );
    (new ExceptionHandler())->onKernelException(
        exceptionEvent: $exceptionEvent,
    );

    $response = $exceptionEvent->getResponse();
    $content = $response?->getContent() ?? '';
    expect($response)->toBeInstanceOf(Response::class)
        ->and($content)
        ->toBeJson();
});
