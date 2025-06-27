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
    private ProductRepositoryInterface $mockRepository;
    private ProductService $service;

    protected function setUp():void
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

    public function testCuandoIncrementoElStockEntoncesElProductoSeAlmacena()
    {
        //Arrange (Configuración)
        $productName = "Camiseta";
        $initialStock = 10;
        $increment = 5;

        $product = new Product();
        $product->name = $productName;
        $product->stock = $initialStock;

        $this->mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn($product);

        $this->mockRepository->shouldReceive('save')
            ->with(Mockery::on(fn($product) => $product->stock === 15))
            ->once()
            ->andReturn(true);        

        //Act & Assert (Ejecución & Validaciones)
        $this->assertTrue($this->service->incrementStock($productName, $increment));

    }

    public function testCuandoIncrementoElStockDeUnProductoInexistenteEntoncesSeLanzaExcepcion()
    {
        //Arrange (Configuración)
        $productName = "Articulo Inexistente";
        $increment = 5;        

        $this->mockRepository->shouldReceive('findByName')
            ->with($productName)
            ->once()
            ->andReturn(null);


        //Expectativas
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto no encontrado");
        $this->mockRepository->shouldNotReceive('save');


        //Act (Ejecución)
        $this->service->incrementStock($productName, $increment);

    }

    public function testCuandoElIncrementoEsMenorACeroEntoncesSeLanzaExcepcion()
    {
        //Arrange (Configuración)
        $productName = "Camiseta";
        $increment = -5;
        
        //Expectativas
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("El incremento debe ser un valor positivo.");

        //Act (Ejecución)
        $this->service->incrementStock($productName, $increment);

 
    }

    public function testCuandoElIncrementoEsCeroEntoncesSeLanzaExcepcion()
    {
        //Arrange (Configuración)
        $productName = "Camiseta";
        $increment = 0;
        
        //Expectativas
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("El incremento debe ser un valor positivo.");

        //Act (Ejecución)
        $this->service->incrementStock($productName, $increment);

 
    }
}