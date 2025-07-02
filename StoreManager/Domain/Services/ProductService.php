<?php

namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Exceptions\ProductNotFoundException;

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
        $product = $this->findProductByName($productName);
        $this->updateStock($product, $increment);
        return $this->saveProduct($product);
    }

    private function updateStock(Product $product, int $increment): void
    {
        $product->stock += $increment;
    }

    private function findProductByName(string $productName): ?Product
    {
        $product = $this->productRepository->findByName($productName);
        if ($product === null){
            throw new ProductNotFoundException($productName);
        }
        return $this->productRepository->findByName($productName);
    }

    private function saveProduct(Product $product): bool
    {
        return $this->productRepository->save($product);
    }


}