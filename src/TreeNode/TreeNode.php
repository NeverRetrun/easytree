<?php


namespace EasyTree\TreeNode;


class TreeNode
{
    private $nodeHeight = 1;

    private $data;

    private $childrenDepth;

    public function __construct(array $data, int $nodeHeight)
    {
        $this->data = $data;
        $this->nodeHeight = $nodeHeight;
    }
}