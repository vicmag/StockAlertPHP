<?
declare(strinct_types=1);

namespace StoreManager\Test\Unit\Domain\Services;

use Codeception\Test\Unit;
use Mockery;

class ProductServiceTest extends Unit
{
    public function testCuandoIncrementamosStockEntoncesTodoOk()
    {
        //Estructura AAA
        //Arrange (configuración)
        $nombreProducto = 'Camiseta';
        $stockInicial = 10;
        $incremento = 5;

        $product = new Product();
        $product->nombre = $nombreProducto;
        $product->stock =  $stockInicial;

        

        //Act (ejcución)
        //Assert (validación)
    }
}