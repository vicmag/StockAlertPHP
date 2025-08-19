<?php
declare(strict_types=1);

namespace StoreManager\Tests\Unit\Domain\Services;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use Mockery;
use Codeception\Test\Unit;

class ProductServiceTest extends Unit
{
    protected \Tests\Support\UnitTester $tester;


    public function testIncreaseStockShouldIncrementProductStock()
    {
        // Arrange
        $productName = 'Camiseta';
        $initialStock = 10;
        $incrementAmount = 5;
        
        $mockProduct = new Product();
        $mockProduct->name = $productName;
        $mockProduct->stock = $initialStock;
        
        // Mock del repositorio
        $mockRepo = Mockery::mock(ProductRepositoryInterface::class);
        $mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($mockProduct);
            
        $mockRepo->shouldReceive('save')
            ->with(Mockery::on(function ($product) use ($initialStock, $incrementAmount) {
                return $product->stock === ($initialStock + $incrementAmount);
            }))
            ->once()
            ->andReturn(true);
        
        $service = new ProductService($mockRepo);

        // Act
        $result = $service->increaseStock($productName, $incrementAmount);

        // Assert
        $this->assertTrue($result);

        Mockery::close();
    }
}
?>