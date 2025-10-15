<?
declare(strict_types=1);

namespace StoreManager\Test\Unit\Domain\Services;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use StoreManager\Domain\Exceptions\ProductNotFoundException;
use Codeception\Test\Unit;
use Mockery;

class ProductServiceTest extends Unit
{
    public function testCuandoIncrementamosElStockEntoncesSeAlmacenaCorrectamente()
    {
        //Arrange (Configuración)
        $nombreProducto = 'Camiseta';
        $stockInicial = 10;
        $incremento = 5;

        $product = new Product();
        $product->nombre = $nombreProducto;
        $product->stock = $stockInicial;

        $mockDB = Mockery::mock(ProductRepositoryInterface::class);
        //expectativas (stubs)
        $mockDB->shouldReceive('findByName')
            ->with($nombreProducto)
            ->andReturn($product)
            ->once();

        $mockDB->shouldReceive('save')
            ->with(Mockery::on(function($product) use ($stockInicial,$incremento){
                return $product->stock === ($stockInicial + $incremento);
            }))
            ->andReturn(true)
            ->once();

        $servicio = new ProductService($mockDB);

        //Act (Ejecución)
        $result = $servicio->incrementaStock($nombreProducto, $incremento);
        
        //Assert (Validación)
        $this->assertTrue($result);
        Mockery::close();

    }

    public function testDebeLanzarUnaExcepcionCuandoElArticuloNoSeEncuentra()
    {
        //Arrange (Configuración)
        $nombreProducto = 'ProductoInexistente';
        $incremento = 5;

        //Implementación de BD para pruenas
        $mockDB = Mockery::mock(ProductRepositoryInterface::class);

        //expectativas (stubs)
        $mockDB->shouldReceive('findByName')
            ->with($nombreProducto)
            ->andReturn(null)
            ->once();

        $mockDB->shouldReceive('save')
            ->never();

        $servicio = new ProductService($mockDB);

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto no encontrado");

        //Act (Ejecución)
        $servicio->incrementaStock($nombreProducto, $incremento);
        
        //Assert (Validación)
        Mockery::close();

    }
}