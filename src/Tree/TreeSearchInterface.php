<?php declare(strict_types=1);


namespace EasyTree\Tree;


use EasyTree\TreeNode\TreeNode;

interface TreeSearchInterface
{
    /**
     * 搜索的过程记录搜索路径上的node
     * 根据路径搜索 类似 ['营销中心', '总部', '设计部'] 搜索出一众的node
     * @return array
     */
    public function searchNodes(): array;

    /**
     * 搜索只搜索一个node值
     * @return TreeNode
     */
    public function searchNode(): TreeNode;
}