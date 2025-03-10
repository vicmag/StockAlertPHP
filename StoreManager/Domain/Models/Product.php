<?php

namespace StoreManager\Domain\Models;

class Product
{
    private $id;
    private $name;
    private $stock;
    private $minimumStockLevel;

    public function __construct(int $id, string $name, int $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stock = $stock;
    }

    public function setMinimumStockLevel(int $level): void
    {
        $this->minimumStockLevel = $level;
    }

    public function getMinimumStockLevel(): int
    {
        return $this->minimumStockLevel;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}