<?php

namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }    

    public function incrementStock(string $productName, int $increment):bool
    {
        // Implementación de la fase verde
        $product = $this->productRepository->findByName($productName);
        $product->stock += $increment;
        return $this->productRepository->save($product);
    }
}