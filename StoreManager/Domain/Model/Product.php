<?php

namespace StoreManager\Domain\Model;

class Product
{
    private $id;
    private $name;
    private $currentStock;
    private $lowStockThreshold;

    public function __construct(string $id, string $name, int $currentStock, int $lowStockThreshold)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currentStock = $currentStock;
        $this->lowStockThreshold = $lowStockThreshold;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrentStock(): int
    {
        return $this->currentStock;
    }

    public function getLowStockThreshold(): int
    {
        return $this->lowStockThreshold;
    }
}