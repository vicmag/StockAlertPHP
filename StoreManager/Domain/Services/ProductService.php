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

    public function incrementStock(string $productName, int $increment): bool
    {
        //Implementacion vacia para la fase roja
        throw new \Exception("No implementado. Fase roja");
    }

}