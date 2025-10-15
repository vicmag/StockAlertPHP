<?
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;

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
        $product = $this->buscaPorNombre($nombre);
        $product->stock += $increment;
        return $this->guardaProducto($product);
    }

    private function buscaPorNombre(string $nombre): Product
    {
        return $this->bd->findByName($nombre);
    }

    private function guardaProducto($product)
    {
        return $this->bd->save($product);
    }


}