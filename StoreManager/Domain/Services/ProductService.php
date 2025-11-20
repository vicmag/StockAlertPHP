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

    public function incrementStock(string $nombre, int $incremento) : bool
    {
        //Implementación vacia. Fase Roja
        return false;
    }
}