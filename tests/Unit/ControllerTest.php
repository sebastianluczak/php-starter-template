<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Infrastructure\Order\Controller;

use App\Presentation\Controller\CreateOrder;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

it('Index method is of proper Response class for POST method.', function () {
    $content = (string)json_encode(['products' => []]);
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
        content: $content,
    );
    $jsonResponse = (new \App\Presentation\Controller\CreateOrder())->index($request);
    expect($jsonResponse)->toBeInstanceOf(Response::class);
});

it('Returns exception for GET method.', function () {
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'GET',
        ],
    );
    (new CreateOrder())->index($request);
})->throws(MethodNotAllowedHttpException::class);

it('Returns exception for missing parameters in method.', function () {
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
    );
    (new CreateOrder())->index($request);
})->throws(BadRequestException::class);

it('Returns exception for zero amount of products given.', function () {
    $content = (string)json_encode(['products' => [[
        'name' => 'test 1',
        'amount' => 0,
    ]]]);
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
        content: $content,
    );
    (new \App\Presentation\Controller\CreateOrder())->index($request);
})->throws(\Exception::class, 'Cannot request zero amount of test 1');

it('Returns out of stock exception for absurd amount of products given.', function () {
    $content = (string)json_encode(['products' => [[
        'name' => 'test 1',
        'amount' => 9_999_999,
    ]]]);
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
        content: $content,
    );
    (new \App\Presentation\Controller\CreateOrder())->index($request);
})->throws(\Exception::class, 'Out of stock for test 1');


it('Returns proper message with 200 status code.', function () {
    $content = (string)json_encode(['products' => [[
        'name' => 'test product 1',
        'amount' => 1,
    ],[
        'name' => 'test product 2',
        'amount' => 1,
    ]]]);
    $request = new Request(
        server: [
            'REQUEST_METHOD' => 'POST',
        ],
        content: $content,
    );
    $jsonResponse = (new CreateOrder())->index($request);
    $content = $jsonResponse->getContent();
    $json = json_decode(is_string($content) ? $content : '');
    assert(is_object($json) && isset($json->message, $json->total_price));
    expect($json)->toHaveProperty('message')
        ->and($json->message)
        ->toBe('Order created')
        ->and($jsonResponse->getStatusCode())
        ->toBe(Response::HTTP_OK)
        ->and($json->total_price)
        ->toBeFloat()->toBeGreaterThan(0)
    ;
});
