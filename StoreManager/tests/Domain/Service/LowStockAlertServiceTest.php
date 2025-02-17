<?php

namespace StoreManager\Tests\Domain\Service;

use PHPUnit\Framework\TestCase;
use StoreManager\Domain\Model\Product;
use StoreManager\Domain\Repository\ProductRepositoryInterface;
use StoreManager\Domain\Service\LowStockAlertService;

class LowStockAlertServiceTest extends TestCase
{
    public function testCheckLowStock_WhenStockIsLow_ReturnsTrue()
    {
        // Arrange
        $product = new Product("1", "Product A", 5, 10); // Stock bajo
        $mockRepository = $this->createMock(ProductRepositoryInterface::class);
        $mockRepository->method('findById')->willReturn($product);

        $service = new LowStockAlertService($mockRepository);

        // Act
        $isLowStock = $service->checkLowStock("1");

        // Assert
        $this->assertTrue($isLowStock);
    }
}