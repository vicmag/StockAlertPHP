<?php
namespace StoreManager\Application\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;

class ProductService
{
    private ProductRepositoryInterface $productRepository;
    
    public function __construct(ProductRepositoryInterface $productRepository) 
    {
        $this->productRepository = $productRepository;
    }
    
    public function increaseStock(string $productName, int $amount): bool
    {
        // 1. Buscar el producto
        $product = $this->productRepository->findByName($productName);

        // 2. Incrementar el stock
        $product->stock += $amount;

        // 3. Guardar los cambios
        return $this->productRepository->save($product);
    }
}
