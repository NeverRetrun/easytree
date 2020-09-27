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

    public function __construct(array $nodes, TreeBuilder $treeBuilder)
    {
        $this->nodes   = $nodes;
        $this->builder = $treeBuilder;
    }

    public function toArray(): array
    {
        $children = $this->nodes[$this->builder->getRootId()]->getChildren();
        $nodes = [];
        foreach ($children as $child) {
            $nodes[] = $child->toArrayIncludeSelf($this->builder->getChildrenKey());
        }

        return $nodes;
    }

    public function toJson(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_UNESCAPED_UNICODE
        );
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