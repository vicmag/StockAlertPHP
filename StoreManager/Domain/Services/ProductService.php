<?php
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function incrementStock(string $productName, int $increment): bool
    {
        //Buscar el producto por nombre
        $product = $this->productRepository->findByName($productName);

        //Incrementar el stock
        $product->stock += $increment;

        //Guardar los cambios
        return $this->productRepository->save($product);
    }

}