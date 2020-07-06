<?php

namespace EasyTree\Tree;

use EasyTree\Exception\NotFoundNode;
use EasyTree\TreeNode\TreeNode;

interface TreeInterface
{
    /**
     * 根据路径搜索 类似 ['营销中心', '总部', '设计部'] 搜索出一众的node
     * @param string $key
     * @param array $values
     * @param array|null $tree
     * @return array <TreeNode>
     * @throws NotFoundNode
     */
    public function searchNodes(string $key, array $values, ?array $tree = null): array;

    /**
     * 搜索的过程记录搜索路径上的node
     * @param string $key
     * @param $value
     * @param array|null $tree
     * @param array $path
     * @return array <TreeNode>
     * @throws NotFoundNode
     */
    public function searchNodePath(string $key, $value, ?array $tree = null, array $path = []): array;

    /**
     * 搜索只搜索一个node值
     * @param string $key
     * @param $value
     * @param array|null $tree
     * @return TreeNode
     * @throws NotFoundNode
     */
    public function searchNode(string $key, $value, ?array $tree = null): TreeNode;

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
     * @param string $uniquelyKey
     * @return TreeInterface
     */
    public static function from(array $tree, string $uniquelyKey): TreeInterface;

    /**
     * 设置节点树
     * @param array|null $tree
     * @param TreeNode|null $treeNode
     * @return TreeInterface
     */
    public function setNodeTree(?array $tree = null, ?TreeNode $treeNode = null): TreeInterface;

    /**
     * 获取节点树
     * @return array
     */
    public function getNodeTree(): array;
}