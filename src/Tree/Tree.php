<?php


namespace EasyTree\Tree;


class Tree
{
    /**
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * 树节点
     * @var Node[]
     */
    protected $nodes = [];

    public function toArray(): array
    {

    }

    public function toJson(): array
    {

    }

    /**
     * @param \Closure(Node):bool $handle
     * @return Tree
     */
    public function each(callable $handle): Tree
    {

    }

    public function macro()
    {

    }

    public function search(callable $handle): Node
    {

    }

    public function searchAll(callable $handle): array
    {

    }

    public function contain(callable $handle): bool
    {

    }

    public function getChildTree(callable $handle): Tree
    {

    }

    public function isOverHeight(int $limitHeight): bool
    {

    }
}