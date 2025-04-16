<?php
declare(strict_types=1);

namespace StoreManager\Tests\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Application\Services\ProductService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testIncreaseStockShouldIncrementProductStock()
    {
        // Arrange
        $productName = 'Camiseta';
        $initialStock = 10;
        $incrementAmount = 5;
        
        $mockProduct = new Product();
        $mockProduct->name = $productName;
        $mockProduct->stock = $initialStock;
        
        $mockRepo = Mockery::mock(ProductRepositoryInterface::class);
        $mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($mockProduct);
            
        $mockRepo->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $product->stock === 15))
            ->once()
            ->andReturn(true);
        
        $service = new ProductService($mockRepo);

        // Act & Assert
        $this->assertTrue($service->increaseStock($productName, $incrementAmount));
    }
}
