<?php

declare (strict_types=1);

namespace EasyTree\Adapter;


use EasyTree\Adapter\Handler\ArrayAdapter;
use EasyTree\Adapter\Handler\StdClassAdapter;
use EasyTree\Exception\NotSupportType;
use StdClass;

class DefaultAdapter
{
    public static function source($source): AbstractAdapter
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