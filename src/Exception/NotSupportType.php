<?php

declare (strict_types=1);

namespace EasyTree\Exception;


use Throwable;

class NotSupportType extends \InvalidArgumentException
{
    public function __construct($message = "not support data type", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}