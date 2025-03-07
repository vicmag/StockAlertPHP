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
        $product = $this->productRepository->findById($productId);
        if ($product === null) {
            throw new \InvalidArgumentException("Product not found.");
        }

        if ($minimumStockLevel <= 0) {
            throw new \InvalidArgumentException("Minimum stock level must be greater than zero.");
        }

        $product->setMinimumStockLevel($minimumStockLevel);
        return $this->productRepository->save($product);
    }
}