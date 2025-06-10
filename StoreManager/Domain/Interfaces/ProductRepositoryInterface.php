<?php
namespace StoreManager\Domain\Interfaces;

use StoreManager\Domain\Models\Product;

interface ProductRepositoryInterface
{
    public function findByName(String $name): ?Product;  
    public function save(Product $product): bool; 
}
?>