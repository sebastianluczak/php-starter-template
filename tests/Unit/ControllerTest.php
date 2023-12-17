<?php

declare(strict_types=1);

namespace BDev\Tests\Foo;

use BDev\Foo\Controller;
use Symfony\Component\HttpFoundation\Response;

it('Index method is of proper Response class.', function () {
    $jsonResponse = (new Controller())->index();
    expect($jsonResponse)->toBeInstanceOf(Response::class);
});

it('Returns Hello World message with 200 status code.', function () {
    $jsonResponse = (new Controller())->index();
    $content = $jsonResponse->getContent();
    $json = json_decode(is_string($content) ? $content : '');
    assert(is_object($json) && isset($json->message));
    expect($json)->toHaveProperty('message')
        ->and($json->message)
        ->toBe('Hello, World!')
        ->and($jsonResponse->getStatusCode())
        ->toBe(Response::HTTP_OK);
});
