<?php

declare(strict_types=1);

namespace StoreManager\Test\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use StoreManager\Domain\Exceptions\ProductNotFoundException;
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

    public function testCuandoIncrementoElStockDeUnProductoInexistenteEntoncesSeLanzaExcepcion()
    {
        //Arrange (Configuración)
        $productName = "Articulo Inexistente";
        $increment = 5;

        $mockRepository = Mockery::mock(ProductRepositoryInterface::class);

        $mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn(null);

        $service = new ProductService($mockRepository);

        //Expectativas
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto no encontrado: $productName");


        //Act (Ejecución)
        $service->incrementStock($productName, $increment);

    }
}