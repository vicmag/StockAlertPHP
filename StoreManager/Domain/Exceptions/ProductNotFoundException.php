<?php
namespace StoreManager\Domain\Exceptions;

class ProductNotFoundException extends \Exception
{
    public function __construct(string $productName)
    {
        parent::__construct("Producto no encontrado: $productName");
    }
}