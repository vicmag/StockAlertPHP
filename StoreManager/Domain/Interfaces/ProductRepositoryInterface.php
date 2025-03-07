<?php

namespace StoreManager\Domain\Interfaces;

use StoreManager\Domain\Models\Product;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;
    public function save(Product $product): bool;
}