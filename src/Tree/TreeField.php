<?php


namespace EasyTree\Tree;


trait TreeField
{
    /**
     * 树形数据
     * @var array
     */
    private $tree;

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
}