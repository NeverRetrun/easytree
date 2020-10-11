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
     * 遍历树
     * @param \Closure(Node):bool $handle
     * @return Tree
     */
    public function each(callable $handle): Tree
    {
        $root = $this->getRoot();
        foreach ($root->getChildrenIterable() as $node) {
            $result = $handle($node);

            if (false === $result) {
                break;
            }
        }

        return $this;
    }

    /**
     * 搜索值
     * @param \Closure(Node):bool $handle
     * @return Tree
     */
    public function search(callable $handle): Node
    {
        $root = $this->getRoot();
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                return $node;
            }
        }

        throw new NotFoundNode();
    }

    /**
     * 遍历树搜索
     * @param \Closure(Node):bool $handle
     * @return array
     */
    public function searchAll(callable $handle): array
    {
        $root  = $this->getRoot();
        $nodes = [];
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                $nodes[] = $node;
            }
        }

        return $nodes;
    }

    /**
     * 判断是否包含某个值
     * @param callable $handle
     * @return bool
     */
    public function contain(callable $handle): bool
    {
        $root = $this->getRoot();
        foreach ($root->getChildrenIterable() as $node) {
            if ($handle($node) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * 子节点转树
     * @param callable $handle
     * @return Tree
     */
    public function getChildTree(callable $handle): Tree
    {
        return $this->search($handle)->toTree($this->builder);
    }

    /**
     * 判断树是否超出高度
     * @param int $limitLevel
     * @return bool
     */
    public function isOverLevel(int $limitLevel): bool
    {
        return $this->getRoot()->getMaxLevel() < $limitLevel;
    }

    /**
     * 获取root的子节点
     * @return Node[]
     */
    protected function getRootChildren(): array
    {
        return $this->getRoot()->getChildren();
    }

    /**
     * 获取root节点
     * @return Node
     */
    protected function getRoot(): Node
    {
        return $this->nodes[$this->builder->getRootId()];
    }
}