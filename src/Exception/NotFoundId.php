<?php


namespace EasyTree\Exception;


use InvalidArgumentException;
use Throwable;

class NotFoundId extends TreeException
{
    public function __construct($message = "not found id", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}