<?php declare(strict_types=1);


namespace EasyTree\Exception;


use Throwable;

class NotFoundNode extends \RuntimeException
{
    public function __construct($message = "not found node", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}