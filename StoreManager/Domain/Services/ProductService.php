<?
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Exceptions\ProductNotFoundException;
use StoreManager\Domain\Interfaces\ProductRepositoryInterface;
use StoreManager\Domain\Models\Product;

class ProductService
{
    private $db;

    public function __construct(ProductRepositoryInterface $db){
        $this->db = $db;
    }

    public function incrementStock(string $productName, int $increment): bool
    {
        //Fase Verde
        $product = $this->findProduct($productName);

        $product->stock += $increment;

        return $this->saveProduct($product);
    }

    private function findProduct($productName): ?Product
    {
        $product = $this->db->findByName($productName);
        if ($product === null){
            throw new ProductNotFoundException("Producto '{$productName}' no encontrado");
        }
        return $product;
    }


    private function saveProduct($product): bool
    {
        return $this->db->save($product);
    }
}
?>