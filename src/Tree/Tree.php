<?php


namespace EasyTree\Tree;


use EasyTree\Exception\NotFoundUniquelyKey;
use EasyTree\TreeNode\TreeNode;

class Tree implements TreeInterface
{
    use TreeField;

    /**
     * @var array 原数据
     */
    private $sourceData;

    /**
     * 需要隐藏的键值 类似 ['id', 'name']
     * @var array
     */
    private $hidden = [];

    public function __construct(array $sourceData)
    {
        $this->sourceData = $sourceData;
    }

    /**
     * @param array $tree
     * @return TreeInterface
     */
    public static function from(array $tree): TreeInterface
    {
        return (new self($tree))
            ->setTree($tree);
    }

    public function generate(): TreeInterface
    {
        if (null === $this->uniquelyKey){
            throw new NotFoundUniquelyKey();
        }
    }

    public function searchNodes(): array
    {

    }

    public function searchNode(): TreeNode
    {

    }

    public function appendSubsetCount(): TreeInterface
    {

    }

    public function toRow(): array
    {

    }

    public function toArray(): array
    {

    }


}