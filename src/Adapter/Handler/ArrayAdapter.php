<?php

declare (strict_types=1);

namespace EasyTree\Adapter\Handler;

use EasyTree\Adapter\AbstractAdapter;

class ArrayAdapter extends AbstractAdapter
{
    private $source;

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    public function offsetExists($offset)
    {
        return isset($this->source[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->source[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->source[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->source[$offset]);
    }

    public function toArray(): array
    {
        return $this->source;
    }
}