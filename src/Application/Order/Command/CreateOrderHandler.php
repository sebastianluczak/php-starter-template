<?php

declare(strict_types=1);

namespace App\Application\Order\Command;

use App\Application\Order\Repository\OrderRepositoryInterface;
use App\Application\Product\Repository\ProductRepositoryInterface;
use App\Domain\Event\OrderCreated;

final readonly class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(CreateOrder $createOrder): OrderCreated
    {
        $products = $this->productRepository->getByProperties(
            properties: $createOrder->products
        );

        $requestedStock = [];
        foreach ($createOrder->products as $product) {
            $requestedStock[$product['name']] = $product['amount'];
        }

        return new OrderCreated(
            order: $this->orderRepository->create(
                products: $products,
                amounts: $requestedStock
            )
        );
    }
}
