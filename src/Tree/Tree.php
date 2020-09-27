<?php


namespace EasyTree\Tree;


use EasyTree\Exception\NotFoundNode;

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

    /**
     * @return array
     */
    public function toArray(): array
    {
        $children = $this->getRootChildren();
        $nodes    = [];
        foreach ($children as $child) {
            $nodes[] = $child->toArray();
        }

        return $nodes;
    }

    /**
     * @return string
     */
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
        $root = $this->nodes[$this->builder->getRootId()];
        foreach ($root->getChildrenIterable() as $node) {
            $result = $handle($node);

            if (false === $result) {
                break;
            }
        }

        return $this;
    }

    public function macro()
    {

    }

    /**
     * @param \Closure(Node):bool $handle
     * @return Tree
     */
    public function search(callable $handle): Node
    {
        $root = $this->nodes[$this->builder->getRootId()];
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                return $node;
            }
        }

        throw new NotFoundNode();
    }

    /**
     * @param \Closure(Node):bool $handle
     * @return array
     */
    public function searchAll(callable $handle): array
    {
        $root = $this->nodes[$this->builder->getRootId()];
        $nodes = [];
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                $nodes[] = $node;
            }
        }

        return $nodes;
    }

    public function contain(callable $handle): bool
    {
        $root = $this->nodes[$this->builder->getRootId()];
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                return true;
            }
        }

        return false;
    }

    public function getChildTree(callable $handle): Tree
    {

    }

    public function isOverHeight(int $limitHeight): bool
    {

    }

    /**
     * @return Node[]
     */
    protected function getRootChildren(): array
    {
        return $this->nodes[$this->builder->getRootId()]->getChildren();
    }
}