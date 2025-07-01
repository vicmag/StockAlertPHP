<?php

namespace StoreManager\Domain\Interfaces;

use StoreManager\Domain\Models\Product;

interface ProductRepositoryInterface
{
    public function findByName(string $name): Product;
    public function save(Product $product): bool;

}