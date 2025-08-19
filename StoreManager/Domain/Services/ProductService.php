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
        // 1. Buscar el producto por nombre
        $product = $this->productRepository->findByName($productName);
        
        // 2. Incrementar el stock con la cantidad especificada
        $product->stock += $amount;
        
        // 3. Guardar los cambios y retornar el resultado
        return $this->productRepository->save($product);
    }
}
?>