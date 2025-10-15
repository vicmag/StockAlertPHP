<?
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{   
    private $bd;

    public function __construct(ProductRepositoryInterface $bd)
    {
        $this->bd = $bd;
    }

    public function incrementaStock(string $nombre, int $increment): bool
    {
        //Fase Verde
        $product = $this->bd->findByName($nombre);
        $product->stock += $increment;
        return $this->bd->save($product);
    }
}