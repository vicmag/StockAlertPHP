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
        $product = $this->findProductOrFail($productId);
        $this->validateMinimumStockLevel($minimumStockLevel);

        $product->setMinimumStockLevel($minimumStockLevel);
        return $this->productRepository->save($product);
    }

    private function findProductOrFail(int $productId): Product
    {
        $product = $this->productRepository->findById($productId);
        if ($product === null) {
            throw new \InvalidArgumentException("Product not found.");
        }
        return $product;
    }

    private function validateMinimumStockLevel(int $minimumStockLevel): void
    {
        if ($minimumStockLevel <= 0) {
            throw new \InvalidArgumentException("Minimum stock level must be greater than zero.");
        }
    }
}