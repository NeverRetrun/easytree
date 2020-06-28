<?php declare(strict_types=1);


namespace EasyTree\Tree;


use EasyTree\Exception\NotFoundNode;
use EasyTree\TreeNode\TreeNode;

trait TreeSearcher
{
    use TreeField;

    /**
     * 根据路径搜索 类似 ['营销中心', '总部', '设计部'] 搜索出一众的node
     * @param string $key
     * @param array $values
     * @param array|null $tree
     * @return array
     */
    public function searchNodes(string $key, array $values, ?array $tree = null): array
    {
        $result = [];
        foreach ($values as $value) {
            $node = $this->searchNode($key, $value, $tree);

            $tree = $node->toTree()
                ->setNodeTree()
                ->getNodeTree();

            $result[] = $node;
        }

        return $result;
    }

    /**
     * 比较某个key的值来搜索节点
     * @param string $key
     * @param $value
     * @param array|null $tree
     * @return TreeNode
     * @throws NotFoundNode
     */
    public function searchNode(string $key, $value, ?array $tree = null): TreeNode
    {
        if ($this->nodeTree === null) {
            $this->setNodeTree();
        }

        if ($tree === null) {
            $tree = $this->nodeTree;
        }

        /**
         * @var $node TreeNode
         */
        foreach ($this->getIterable($tree) as $node) {
            if ($node->data[$key] === $value) {
                return $node;
            }

            if (count($node->children) > 0) {
                try {
                    //如果在该线路搜索不到节点则跳过至下一个
                    return $this->searchNode($key, $value, $node->children);
                } catch (NotFoundNode $e) {
                    continue;
                }
            }
        }

        throw new NotFoundNode();
    }

    /**
     * 比较某个key的值来搜索节点 并保存搜索的路径
     * @param string $key
     * @param $value
     * @param array|null $tree
     * @param array $path
     * @return array
     */
    public function searchNodePath(string $key, $value, ?array $tree = null, array $path = []): array
    {
        if ($this->nodeTree === null) {
            $this->setNodeTree();
        }

        if (null === $tree) {
            $tree = $this->nodeTree;
        }

        if (null === $value) {
            throw new NotFoundNode();
        }

        /**
         * @var $node TreeNode
         */
        foreach ($tree as $node) {
            if ($node->data[$key] === $value) {
                $path[] = $node;
                return $path;
            }

            if (count($node->children) > 0) {
                try {
                    return array_merge($this->searchNodePath($key, $value, $node->children, $path), [$node]);
                }catch (NotFoundNode $exception) {
                    continue;
                }
            }
        }

        throw new NotFoundNode();
    }
}