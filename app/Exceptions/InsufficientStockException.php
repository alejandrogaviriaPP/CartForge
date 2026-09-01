<?php

namespace App\Exceptions;

use RuntimeException;

class InsufficientStockException extends RuntimeException
{
    public static function forProduct(string $name): self
    {
        return new self(__('There is not enough stock for :name', ['name' => $name]));
    }
}
