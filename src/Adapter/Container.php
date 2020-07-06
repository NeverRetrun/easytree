<?php

declare (strict_types=1);

namespace EasyTree\Adapter;


use EasyTree\Exception\NotSupportType;
use StdClass;

class Container
{
    public static function source($source): Adapter
    {
        if (is_array($source)) {
            return new ArrayAdapter($source);
        }

        if ($source instanceof StdClass) {
            return new StdClassAdapter($source);
        }

        throw new NotSupportType();
    }
}