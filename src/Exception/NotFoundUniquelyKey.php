<?php


namespace EasyTree\Exception;


use InvalidArgumentException;
use Throwable;

class NotFoundUniquelyKey extends InvalidArgumentException
{
    public function __construct($message = "not found uniquely key", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}