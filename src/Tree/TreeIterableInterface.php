<?php declare(strict_types=1);


namespace EasyTree\Tree;


interface TreeIterableInterface
{
    public function getIterable(?array $tree = null): iterable;
}