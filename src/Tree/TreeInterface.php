<?php

namespace EasyTree\Tree;

use EasyTree\TreeNode\TreeNode;

interface TreeInterface
{
    /**
     * 遍历树
     * @param array|null $tree
     * @return iterable
     */
    public function getIterable(?array $tree = null): iterable;

    /**
     * 生成树
     * @return TreeInterface
     */
    public function generate(): TreeInterface;

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