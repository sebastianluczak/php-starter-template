<?php

declare(strict_types=1);

namespace App\Application\Order\Repository;

use App\Application\Price\PriceServiceInterface;
use App\Application\Warehouse\StockServiceInterface;
use App\Domain\Order;
use App\Domain\Product\ProductSnapshot;
use DateTimeImmutable;

final readonly class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private PriceServiceInterface $priceService,
        private StockServiceInterface $stockService,
    ) {}

    public function create(array $products, array $amounts): Order
    {
        $snapshots = [];
        foreach ($products as $product) {
            $snapshots[] = new ProductSnapshot(
                product: $product,
                currentPrice: $this->priceService->getCurrentPriceForProduct($product),
                amount: $amounts[$product->name],
                stock: $this->stockService->getCurrentStockForProduct($product),
            );
        }

        return new Order(
            products: $snapshots,
            createdAt: new DateTimeImmutable(),
        );
    }
}
