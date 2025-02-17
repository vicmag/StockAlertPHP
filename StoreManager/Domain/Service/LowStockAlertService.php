<?php

namespace StoreManager\Domain\Service;

use StoreManager\Domain\Model\Product;
use StoreManager\Domain\Repository\ProductRepositoryInterface;

class LowStockAlertService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function checkLowStock(string $productId): bool
    {
        $product = $this->productRepository->findById($productId);
        return $this->isLowStock($product);
    }
    
    private function isLowStock(Product $product): bool
    {
        return $product->getCurrentStock() <= $product->getLowStockThreshold();
    }
}