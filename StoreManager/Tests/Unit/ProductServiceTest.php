<?php

declare(strict_types=1);

namespace StoreManager\Test\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use PHPUnit\Framework\TestCase;
use Mockery;

class ProductServiceTest extends TestCase
{
    public function testCuandoIncrementoElStockEntoncesElProductoSeAlmacena()
    {
        //Arrange (Configuración)
        $productName = "Camiseta";
        $initialStock = 10;
        $increment = 5;

        $product = new Product();
        $product->name = $productName;
        $product->stock = $initialStock;

        $mockRepository = Mockery::mock(ProductRepositoryInterface::class);

        $mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($product);

        $mockRepository->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $product->stock === 15))
            ->once()
            ->andReturn(true);
        $service = new ProductService($mockRepository);

        //Act & Assert (Ejecución & Validaciones)
        $this->assertTrue($service->incrementStock($productName, $increment));

    }
}