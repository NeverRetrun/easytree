<?php


namespace EasyTree\Tree;


use EasyTree\TreeNode\TreeNode;

trait TreeField
{
    /**
     * 树形数据 array<array>
     * @var array
     */
    private $tree;

    /**
     * 树形数据 array<TreeNode>
     * @var array
     */
    public $nodeTree;

    /**
     * 每条数据唯一标识id名
     * @var string
     */
    private $uniquelyKey;

    /**
     * 父级唯一标识id
     * @var string
     */
    private $parentKey = 'parent_id';

    /**
     * 子集的字段名
     * @var string
     */
    private $childKey = 'children';

    /**
     * 子集个数字段名
     * @var string
     */
    private $countSubsetKey = 'subset';

    /**
     * 生成节点对象的树 用于搜索
     * @param array|null $tree
     * @param TreeNode|null $treeNode
     * @return void
     */
    private function setNodeTree(?array $tree = null, ?TreeNode $treeNode = null): void
    {

        if ($tree === null) {
            $tree = $this->tree;
        }

        foreach ($tree as $node) {
            if (null === $treeNode) {
                $nodeObject       = new TreeNode($node, 1);
                $this->nodeTree[] = $nodeObject;
            } else {
                $nodeObject           = new TreeNode($node, $treeNode->nodeHeight + 1);
                $treeNode->children[] = $nodeObject;
            }

            if (isset($node[$this->childKey])) {
                $this->setNodeTree($node[$this->childKey], $nodeObject);
            }
        }
    }

    public function getIterable(?array $tree = null): iterable
    {
        if ($tree === null) {
            $tree = $this->tree;
        }

        foreach ($tree as $node) {
            yield $node;

            if (isset($node[$this->childKey])) {
                foreach ($this->getIterable($node[$this->childKey]) as $childrenNode) {
                    yield $childrenNode;
                }
            }
        }
    }


    /**
     * @param string $uniquelyKey
     * @return $this
     */
    public function setUniquelyKey(string $uniquelyKey)
    {
        $this->uniquelyKey = $uniquelyKey;
        return $this;
    }

    /**
     * @param string $parentKey
     * @return $this
     */
    public function setParentKey(string $parentKey)
    {
        $this->parentKey = $parentKey;
        return $this;
    }

    /**
     * @param string $childKey
     * @return $this
     */
    public function setChildKey(string $childKey)
    {
        $this->childKey = $childKey;
        return $this;
    }

    /**
     * @param array $tree
     * @return $this
     */
    private function setTree(array $tree)
    {
        $this->tree = $tree;
        return $this;
    }

    /**
     * @param string $countSubsetKey
     * @return TreeField
     */
    public function setCountSubsetKey(string $countSubsetKey): TreeField
    {
        $this->countSubsetKey = $countSubsetKey;
        return $this;
    }
}