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

    public function incrementStock(string $productName, int $increment): bool
    {
        $this->validateIncrement($increment);
        
        //Buscar el producto por nombre
        $product = $this->findProductByName($productName);

        //Incrementar el stock
        $this->updateStock($product, $increment);

        //Guardar los cambios
        return $this->saveProduct($product);
    }

    private function validateIncrement(int $increment): void
    {
        if ($increment <= 0){
            throw new \InvalidArgumentException("El incremento debe ser un valor positivo.");
        }
    }

    private function updateStock(Product $product, int $increment): void
    {
        $product->stock += $increment;
    }

    private function findProductByName(string $name): Product
    {
        $product = $this->productRepository->findByName($name);

        if ($product === null) {
            throw new ProductNotFoundException($name);
        }

        return  $product;

    }

    private function saveProduct(Product $product): bool
    {
        return $this->productRepository->save($product);
    }

}