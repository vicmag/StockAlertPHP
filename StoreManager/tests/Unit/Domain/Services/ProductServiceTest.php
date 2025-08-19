<?php
declare(strict_types=1);

namespace StoreManager\Tests\Unit\Domain\Services;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use StoreManager\Domain\Exceptions\ProductNotFoundException;
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

    public function testIncreaseStockShouldThrowExceptionWhenProductNotFound()
    {
        // Arrange
        $productName = 'ProductoInexistente';
        $incrementAmount = 5;
        
        // Mock del repositorio que retorna null (producto no encontrado)
        $mockRepo = Mockery::mock(ProductRepositoryInterface::class);
        $mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn(null);
            
        // El método save nunca debería llamarse
        $mockRepo->shouldReceive('save')
            ->never();
        
        $service = new ProductService($mockRepo);

        // Expectativas de excepción
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto '{$productName}' no encontrado");

        // Act
        $service->increaseStock($productName, $incrementAmount);

        Mockery::close();
    }
}
?>