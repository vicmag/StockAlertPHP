<?php
namespace StoreManager\Application\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function increaseStock(string $productName, int $incrementAmount): bool
    {
        $product = $this->productRepository->findByName($productName);
        $product->stock += $incrementAmount;
        return $this->productRepository->save($product);
    }


}
?>