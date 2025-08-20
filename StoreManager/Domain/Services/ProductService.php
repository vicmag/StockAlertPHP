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
    
    public function increaseStock(string $productName, int $amount): bool
    {
        $product = $this->findProductOrFail($productName);
        
        $this->updateStock($product, $amount);
        
        return $this->persistChanges($product);
    }
    
    private function findProductOrFail(string $name): Product
    {
        $product = $this->productRepository->findByName($name);
        // Implementación guiada por la prueba
        if ($product === null) {
            throw new ProductNotFoundException("Producto '{$name}' no encontrado");
        }
        return $product;
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