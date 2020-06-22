<?php


namespace EasyTree\TreeNode;


class TreeNode
{
    public $nodeHeight = 1;

    public $data;

    public $childrenDepth;

    /**
     * 子集
     * @var array
     */
    public $children = [];

    public function __construct(array $data, int $nodeHeight, array $children = [])
    {
        $this->data = $data;
        $this->nodeHeight = $nodeHeight;
        $this->children = $children;
    }

}