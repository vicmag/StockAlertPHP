<?
namespace StoreManager\Domain\Services;

use StoreManager\Domain\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private $db;

    public function __construct(ProductRepositoryInterface $db){
        $this->db = $db;
    }

    public function incrementStock(string $productName, int $increment): bool
    {
        $product = $this->db->findByName($productName);

        $product->stock += $increment;
        
        return $this->db->save($product);
    }
}