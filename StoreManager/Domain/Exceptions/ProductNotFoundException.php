<?
namespace StoreManager\Domain\Exceptions;

class ProductNotFoundException extends \Exception
{

    public function __construct($productName)
    {
        parent::__construct("No se encontró el producto {$productName}.");
    }
}