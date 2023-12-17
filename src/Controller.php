<?php

declare(strict_types=1);

namespace BDev\Foo;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse(
            data: [
                'message' => 'Hello, World!',
            ],
            status: Response::HTTP_OK
        );
    }
}
