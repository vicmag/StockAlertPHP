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
        //Implementación vacia. Fase Roja
        return true;
    }
}