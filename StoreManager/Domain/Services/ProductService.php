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

    public function incrementStock(string $product, int $increment):bool
    {
        // Implementación vacía. Fase Roja
        throw new \RuntimeException('Método no implementado. Fase Roja');
    }
}