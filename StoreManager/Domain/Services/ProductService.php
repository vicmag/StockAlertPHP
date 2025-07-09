<?php
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function incrementStock(string $productName, int $increment) : bool
    {
        //Fase Verde
        $product = $this->repository->findByName($productName);
        $product->stock += $increment;
        return $this->repository->save($product);
    }
}