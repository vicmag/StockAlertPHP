<?php

namespace StoreManager\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use StoreManager\Domain\Services\ProductService;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;

class ProductServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testSetMinimumStockLevel()
    {
        // Arrange
        $productRepository = m::mock(ProductRepositoryInterface::class);
        $productService = new ProductService($productRepository);

        $productId = 1;
        $minimumStockLevel = 15;

        $productRepository->shouldReceive('findById')
            ->with($productId)
            ->andReturn(new Product($productId, 'Camiseta Azul', 20));

        $productRepository->shouldReceive('save')
            ->with(m::type(Product::class))
            ->andReturn(true);

        // Act
        $result = $productService->setMinimumStockLevel($productId, $minimumStockLevel);

        // Assert
        $this->assertTrue($result);
    }
}