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
        // Implementación vacía para fase roja
        throw new \RuntimeException('Método no implementado');
    }
}
?>