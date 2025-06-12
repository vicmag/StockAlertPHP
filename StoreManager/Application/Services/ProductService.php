<?php
namespace StoreManager\Application\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Exceptions\ProductNotFoundException;
use StoreManager\Domain\Models\Product;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function increaseStock(string $productName, int $incrementAmount): bool
    {
        $product = $this ->findProductByName($productName);
        
        $this->updateStock($product, $incrementAmount);
        return $this->saveProduct($product);
    }

    private function findProductByName(string $name): ?Product
    {
        $product = $this->productRepository->findByName($name);
        if (!$product) {
            throw new ProductNotFoundException($name);
        }
        return $product;
    }

    private function updateStock(Product $product, int $incrementAmount): void
    {
        $product->stock += $incrementAmount;
    }

    private function saveProduct(Product $product): bool
    {
        return $this->productRepository->save($product);
    }

}
?>