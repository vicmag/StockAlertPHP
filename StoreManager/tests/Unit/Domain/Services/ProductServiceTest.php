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

    /** @var Mockery\MockInterface|ProductRepositoryInterface */
    private $mockRepo;
    
    /** @var ProductService */
    private $service;

    /**
     * Configuración común para todos los tests
     */
    protected function _before()
    {
        // 1. Crear el mock del repositorio (común para todos los tests)
        $this->mockRepo = Mockery::mock(ProductRepositoryInterface::class);
        
        // 2. Inicializar el servicio con el mock
        $this->service = new ProductService($this->mockRepo);
    }

    /**
     * Limpieza después de cada test
     */
    protected function _after()
    {
        Mockery::close();
    }


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
        $this->mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($mockProduct);
            
        $this->mockRepo->shouldReceive('save')
            ->with(Mockery::on(function ($product) use ($initialStock, $incrementAmount) {
                return $product->stock === ($initialStock + $incrementAmount);
            }))
            ->once()
            ->andReturn(true);
        

        // Act
        $result = $this->service->increaseStock($productName, $incrementAmount);

        // Assert
        $this->assertTrue($result);

    }

    public function testIncreaseStockShouldThrowExceptionWhenProductNotFound()
    {
        // Arrange
        $productName = 'ProductoInexistente';
        $incrementAmount = 5;
        
        // Mock del repositorio que retorna null (producto no encontrado)
        $this->mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn(null);
            
        // El método save nunca debería llamarse
        $this->mockRepo->shouldReceive('save')
            ->never();

        // Expectativas de excepción
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto '{$productName}' no encontrado");

        // Act
        $this->service->increaseStock($productName, $incrementAmount);
    }

    public function testIncreaseStockShouldThrowExceptionWhenNegativeAmountWouldMakeStockNegative()
    {
        // Arrange
        $productName = 'Camiseta';
        $initialStock = 3;
        $negativeAmount = -5; // Valor negativo que haría el stock negativo
        
        // Configurar producto mock con stock bajo
        $mockProduct = new Product();
        $mockProduct->name = $productName;
        $mockProduct->stock = $initialStock;
        
        // Configurar expectativas del mock
        $this->mockRepo->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($mockProduct);
            
        // El save no debería llamarse si la operación es inválida
        $this->mockRepo->shouldReceive('save')
            ->never();
        
        // Expectativa de excepción
        $this->expectException(InvalidStockOperationException::class);
        $this->expectExceptionMessage('No hay suficiente stock para realizar esta operación');

        // Act
        $this->service->increaseStock($productName, $negativeAmount);
    }
}
?>