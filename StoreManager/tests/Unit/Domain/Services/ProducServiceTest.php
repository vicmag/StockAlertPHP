<?
declare(strict_type=1);

namespace StorageManager\Test\Unit\Domain\Service;

use Codeception\Test\Unit;
use Mockery;

class ProductServiceTest extends Unit
{
    public function testCuandoIncrementoStock_EntoncesSeAlmacenaCorrectamente()
    {
        //Arrange (Configuración)
        $nombreProducto = "Camiseta";
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
            ->with(Mockery::on(function($product) use ($stockInicial, $incremento){
                return $product->stock === ($stockInicial + $incremento);
            }))
            ->andReturn(true)
            ->once();

        $service = new ProductService($mockDB);

        //Act (Ejecución)
        $result = $service->incrementStock($nombreProducto,$incremento);

        //Assert (Validación)
        $this->assertTrue($result);
        Mockery::close();
    }
}
