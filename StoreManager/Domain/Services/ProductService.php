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
        $product = $this->findProductByName($productName);
        $product->stock += $increment;
        return $this->saveProduct($product);
    }

    private function findProductByName($productName){
        return $this->repository->findByName($productName);
    }
 
    private function saveProduct($product){
        return $this->repository->save($product);
    }


}