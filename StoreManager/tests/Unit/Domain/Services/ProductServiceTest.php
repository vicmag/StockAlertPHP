<?
declare(strict_types=1);

namespace StoreManager\Tests\Unit\Domain\Services;

use StoreManager\Domain\Models\Product;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Services\ProductService;
use Mockery;
use Codeception\Test\Unit;

class ProductServiceTest extends Unit
{
    public function testCuandoSeIncrementaElStcokEntoncesSeAlamacenaCorrectamente()
    {
        //Arrange (configuración)
        $productName = 'Camiseta';
        $initialStock = 10;
        $increment = 5;

        $product = new Product();
        $product->name = $productName;
        $product->stock = $initialStock;

        $db = Mockery::mock(ProductRepositoryInterface::class);

        //Definiendo el comportamiento de los mocks (stubs particularment expectativas)
        $db->shouldReceive('findByName')
            ->with($productName)
            ->andReturn($product)
            ->once();
        
        $db->shouldReceive('save')
            ->with(Mockery::on(function($product) use ($initialStock, $increment) { 
                return $product->stock === ($initialStock + $increment);  
            }))
            ->andReturn(true)
            ->once();

        $service = new ProductService($db);

        //Act (ejecución)
        $result = $service->incrementStock($productName, $increment);

        //Assert (validación)
        $this->assertTrue($result);
        Mockery::close();
       
    }
}

?>