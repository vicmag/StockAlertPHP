<?php
declare(strict_types=1);

namespace StoreManager\Tests\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Application\Services\ProductService;
use Mockery;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class ProductServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCuandoIncrementoElStockDeUnProducto_EntoncesElStockAumenta()
    {
        //Arrange (configuración)
        $productName = 'Camiseta';
        $initialStock = 10;
        $incrementAmount = 5;

        $mockProduct = new Product();
        $mockProduct->name = $productName;
        $mockProduct->stock = $initialStock;

        $mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $mockProductRepository->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($mockProduct);

        $mockProductRepository->shouldReceive('save')
            ->with(Mockery::on(function ($product) use ($initialStock, $incrementAmount) {
                return $product->stock === ($initialStock + $incrementAmount);
            }))
            ->once()
            ->andReturn(true);

        $service = new ProductService($mockProductRepository);

        //Act (ejecución)
        $result = $service->increaseStock($productName, $incrementAmount);

        //Assert (validación)
        $this->assertTrue($result);
        Mockery::close();
    }
}