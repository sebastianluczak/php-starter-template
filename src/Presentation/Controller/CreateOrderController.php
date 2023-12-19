<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Order\Command\CreateOrder as CreateOrderCommand;
use App\Application\Order\Command\CreateOrderHandler;
use App\Application\Order\Repository\OrderRepository;
use App\Application\Product\Repository\ProductRepository;
use App\Infrastructure\PriceService;
use App\Infrastructure\Warehouse\CurrentStockService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

final readonly class CreateOrderController
{
    public function index(
        Request $request,
    ): JsonResponse {
        if (!$request->isMethod(Request::METHOD_POST)) {
            throw new MethodNotAllowedHttpException(
                allow: [Request::METHOD_POST],
                message: 'Method not allowed.',
            );
        }
        if (!json_validate($request->getContent())) {
            throw new BadRequestException('Provide proper json.');
        }

        $content = (array)json_decode($request->getContent(), true);
        assert(array_key_exists('products', $content));
        $createOrder = new CreateOrderCommand(
            products: $content['products'],
        );
        $createOrderHandler = new CreateOrderHandler(
            orderRepository: new OrderRepository(
                priceService: new PriceService(),
                stockService: new CurrentStockService(),
            ),
            productRepository: new ProductRepository(),
        );
        $orderCreated = $createOrderHandler($createOrder);

        return new JsonResponse(
            data: [
                'message' => 'Order created',
                'products' => $orderCreated->order->products,
                'total_price' => $orderCreated->getTotalPrice(),
                'coins' => $orderCreated->order->numberOfCoins(),
                'created_at' => $orderCreated->order->createdAt->getTimestamp(),
            ],
            status: Response::HTTP_OK,
        );
    }
}
