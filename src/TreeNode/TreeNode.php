<?php


namespace EasyTree\TreeNode;


use EasyTree\Tree\Tree;
use EasyTree\Tree\TreeInterface;

class TreeNode
{
    /**
     * 节点高度
     * @var int
     */
    public $nodeHeight = 1;

    /**
     * 树节点的数据
     * @var array
     */
    public $data;

    /**
     * 子集的最深的深度
     * @var int
     */
    public $maxChildrenHeight;

    /**
     * 子集
     * @var array
     */
    public $children = [];


    private $uniquelyKey;

    public function __construct(array $data, int $nodeHeight, string $uniquelyKey, array $children = [])
    {
        $this->data       = $data;
        $this->nodeHeight = $nodeHeight;
        $this->children   = $children;
        $this->uniquelyKey = $uniquelyKey;
    }

    /**
     * 设置节点最高高度
     * @return TreeNode
     */
    public function setMaxChildrenHeight(): TreeNode
    {
        $this->maxChildrenHeight = $this->countMaxChildrenHeight();
        return $this;
    }

    /**
     * 计算子集节点高度
     * @return int
     */
    private function countMaxChildrenHeight(): int
    {
        $tree = $this->toTree()
            ->setNodeTree();

        /**
         * @var $node TreeNode
         */
        foreach ($tree->getIterable($tree->getNodeTree()) as $node) {
        }
        return isset($node) ? $node->nodeHeight : $this->nodeHeight;
    }


    public function getUniquelyKeyData()
    {
        return $this->data[$this->uniquelyKey];
    }

    /**
     *
     * @return TreeInterface
     */
    public function toTree(): TreeInterface
    {
        return Tree::from([$this->data], $this->uniquelyKey);
    }
}