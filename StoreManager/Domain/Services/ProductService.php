<?php
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Exceptions\ProductNotFoundException;

class ProductService
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function incrementStock(string $productName, int $increment) : bool
    {
        
        $this->validateIncrement($increment);
        $product = $this->findProductByName($productName);
        $product->stock += $increment;
        return $this->saveProduct($product);
    }

    private function validateIncrement(int $increment): void
    {
        if ($increment <=0){ 
            throw new  \InvalidArgumentException("El incremento debe ser positivo");
        }
    }

    private function findProductByName($productName){
        $product = $this->repository->findByName($productName);
        if ($product === null){
            throw new ProductNotFoundException($productName);
        }
        return $product;
    }
 
    private function saveProduct($product){
        return $this->repository->save($product);
    }


}