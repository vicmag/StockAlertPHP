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
   
    private $mockDB;
    private $servicio;

    protected function _before()
    {
        $this->mockDB = Mockery::mock(ProductRepositoryInterface::class);
        $this->servicio = new ProductService($this->mockDB);
    }

    protected function _after()
    {
        Mockery::close();
    }

    public function testCuandoIncrementamosElStockEntoncesSeAlmacenaCorrectamente()
    {
        //Arrange (Configuración)
        $nombreProducto = 'Camiseta';
        $stockInicial = 10;
        $incremento = 5;

        $product = new Product();
        $product->nombre = $nombreProducto;
        $product->stock = $stockInicial;

        
        //expectativas (stubs)
        $this->mockDB->shouldReceive('findByName')
            ->with($nombreProducto)
            ->andReturn($product)
            ->once();

        $this->mockDB->shouldReceive('save')
            ->with(Mockery::on(function($product) use ($stockInicial,$incremento){
                return $product->stock === ($stockInicial + $incremento);
            }))
            ->andReturn(true)
            ->once();

        //Act (Ejecución)
        $result = $this->servicio->incrementaStock($nombreProducto, $incremento);
        
        //Assert (Validación)
        $this->assertTrue($result);
    

    }

    public function testDebeLanzarUnaExcepcionCuandoElArticuloNoSeEncuentra()
    {
        //Arrange (Configuración)
        $nombreProducto = 'ProductoInexistente';
        $incremento = 5;


        //expectativas (stubs)
        $this->mockDB->shouldReceive('findByName')
            ->with($nombreProducto)
            ->andReturn(null)
            ->once();

        $this->mockDB->shouldReceive('save')
            ->never();

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage("Producto no encontrado");

        //Act (Ejecución)
        $this->servicio->incrementaStock($nombreProducto, $incremento);
        

    }
}