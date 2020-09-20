<?php

declare (strict_types=1);

namespace EasyTree\Adapter;


use StdClass;

class StdClassAdapter extends AbstractAdapter
{
    private $source;

    public function __construct(StdClass $source)
    {
        $this->source = $source;
    }

    public function offsetExists($offset)
    {
        return isset($this->source->{$offset});
    }

    public function offsetGet($offset)
    {
        return $this->source->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        $this->source->{$offset} = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->source->{$offset});
    }

    public function toArray(): array
    {
        return get_object_vars($this->source);
    }
}