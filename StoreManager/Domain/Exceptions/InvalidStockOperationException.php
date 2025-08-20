<?php
namespace StoreManager\Domain\Exceptions;

use DomainException;

class InvalidStockOperationException extends DomainException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>