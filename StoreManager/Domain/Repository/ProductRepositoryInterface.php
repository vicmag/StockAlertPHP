<?php

namespace StoreManager\Domain\Repository;

use StoreManager\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function findById(string $id): ?Product;
}