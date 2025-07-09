<?php

declare(strict_types=1);

namespace StoreManager\Tests\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use PHPUnit\Framework\TestCase;
use Mockery;

class ProductServiceTest extends TestCase{
    public function testGuardaCorrectamenteAlIncrementarElStock()
    {
        //Estructura AAA
        //Arrange (Configuración)
        $productName = 'Camiseta';
        $initialStock = 10;
        $increment = 5;

        $product = new Product();
        $product->name = $productName;
        $product->stock = $initialStock;

        $mockRepository = Mockery::mock(ProductRepositoryInterface::class);

        //Comportamiento del mock (Expectativas)
        $mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->andReturn($product)
            ->once();

        $mockRepository->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $product->stock === $initialStock + $increment ))
            ->andReturn(true)
            ->once();

        $service = new ProductService($mockRepository);

        //Act & Assert (Ejecución & Validación)
        $this->assertTrue($service->incrementStock($productName, $increment));
        Mockery::close();


    }

}