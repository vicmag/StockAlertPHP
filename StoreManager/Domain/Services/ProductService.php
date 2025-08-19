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
    
    public function increaseStock(string $productName, int $amount): bool
    {
        $product = $this->findProductByName($productName);
        $this->updateStock($product, $amount);
        
        return $this->persistChanges($product);
    }
    
    private function findProductByName(string $name): Product
    {
        return $this->productRepository->findByName($name);
    }
    
    private function updateStock(Product $product, int $amount): void
    {
        $product->stock += $amount;
    }
    
    private function persistChanges(Product $product): bool
    {
        return $this->productRepository->save($product);
    }
}
?>