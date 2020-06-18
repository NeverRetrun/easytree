<?php

namespace EasyTree\Tree;

use EasyTree\TreeNode\TreeNode;

interface TreeInterface
{
    /**
     * 生成树
     * @return TreeInterface
     */
    public function generate(): TreeInterface;

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

    /**
     * 追加子集数量字段
     * @return TreeInterface
     */
    public function appendSubsetCount(): TreeInterface;

    /**
     * 树结构转成行结构
     * @return array
     */
    public function toRow(): array;

    /**
     * 获取树的数组
     * @return array
     */
    public function toArray(): array;

    /**
     * 从树数组生成树对象
     * @param array $tree
     * @return TreeInterface
     */
    public static function from(array $tree): TreeInterface;
}