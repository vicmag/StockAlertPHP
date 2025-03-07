<?php

namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function setMinimumStockLevel(int $productId, int $minimumStockLevel): bool
    {
        return false;
        // Implementación vacía para la fase Roja
    }
}