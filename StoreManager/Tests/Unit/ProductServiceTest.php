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
   public function testGuardaElProductoAlincrementarElStock()
   {
        // Arrange (configuración)
        $productName = "Camiseta";
        $initialStock = 10;
        $increment = 5;

        $product = new Product();
        $product->name = $productName;
        $product->stock = $initialStock;

        $mockRepository = Mockery::mock(ProductRepositoryInterface::class);
        
        $mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->andReturn($product)
            ->once();

        $mockRepository->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $initialStock+$increment === $product->stock))
            ->once()
            ->andReturn(true);
        
        $service = new ProductService($mockRepository);

        // Act & Assert (ejecucción & validacion)
        $this->assertTrue($service->incrementStock($productName, $increment));
        

   }
}