<?php

declare(strict_types=1);

namespace StoreManager\Tests\Unit;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use StoreManager\Domain\Exceptions\ProductNotFoundException;
use PHPUnit\Framework\TestCase;
use Mockery;

class ProductServiceTest extends TestCase{

    private ProductRepositoryInterface $mockRepository;
    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->mockRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

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


        //Comportamiento del mock (Expectativas)
        $this->mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->andReturn($product)
            ->once();

        $this->mockRepository->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $product->stock === $initialStock + $increment ))
            ->andReturn(true)
            ->once();

        //Act & Assert (Ejecución & Validación)
        $this->assertTrue($this->service->incrementStock($productName, $increment));

    }

    public function testLanzarExcepciónAlIncrementarConArtículoInexistente(){
        //Arrange
        $productName = 'Artículo Inexistente';
        $increment = 5;        

        //Comportamiento del mock (Expectativas)
        $this->mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->andReturn(null)
            ->once();

        $this->service = new ProductService($this->mockRepository);

        //Expectativas
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Producto no encontrado: ' . $productName);

        //Act & Assert
        $this->service->incrementStock($productName, $increment);
        
    }

    public function testLanzarExcepciónAlIncrementarConCantidadNegativa(){
        //Arrange
        $productName = 'Camiseta';
        $increment = -5;
        //Expectativas
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("El incremento debe ser positivo");
        $this->mockRepository->shouldNotReceive('findByName');
        $this->mockRepository->shouldNotReceive('save');

        //Act & Assert
        $this->service->incrementStock($productName, $increment);
    }

    public function testLanzarExcepciónAlIncrementarConCantidadCero(){
        //Arrange
        $productName = 'Camiseta';
        $increment = 0;
        //Expectativas
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("El incremento debe ser positivo");
        $this->mockRepository->shouldNotReceive('findByName');
        $this->mockRepository->shouldNotReceive('save');

        //Act & Assert
        $this->service->incrementStock($productName, $increment);
    }


}