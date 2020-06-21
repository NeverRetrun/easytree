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
     * 数组树 to 对象
     * @param array $tree
     * @return TreeInterface
     */
    public static function from(array $tree): TreeInterface
    {
        return (new self($tree))
            ->setTree($tree);
    }

    /**
     * 生成树
     * @param bool $isSaveParentId
     * @return TreeInterface
     */
    public function generate(bool $isSaveParentId = false): TreeInterface
    {
        if (null === $this->uniquelyKey){
            throw new NotFoundUniquelyKey();
        }

        $idMap = [];
        $hiddenMap = array_flip($this->hidden);
        $isHidden = count($hiddenMap) > 0;

        foreach ($this->sourceData as $item) {
            if ($isHidden) {
                foreach ($item as $key => $value) {
                    if (isset($hiddenMap[$key])) {
                        unset($item[$key]);
                    }
                }
            }

            $idMap[$item[$this->uniquelyKey]] = $item;
        }

        $result = [];
        foreach ($idMap as &$item) {
            if (isset($idMap[$item[$this->parentKey]]) && !empty($idMap[$item[$this->parentKey]])) {
                $idMap[$item[$this->parentKey]][$this->childKey][] = &$item;
            } else {
                $result[] = &$item;
            }
            if ($isSaveParentId === false) {
                unset($item[$this->parentKey]);
            }

        }

        $this->tree = $result;
        return $this;
    }

    /**
     * 追加计算子集个数字段
     * @param array|null $tree
     * @return TreeInterface
     */
    public function appendSubsetCount(?array &$tree = null): TreeInterface
    {
        if (null === $tree) {
            $tree =& $this->tree;
        }

        foreach ($tree as &$node) {
            if (isset($node[$this->childKey])) {
                $node[$this->countSubsetKey] = count($node[$this->childKey]);
                $this->appendSubsetCount($node[$this->childKey]);
            } else {
                $node[$this->countSubsetKey] = 0;
            }
        }

        return $this;
    }

    /**
     * 将树结果转成行结果
     * @return array
     */
    public function toRow(): array
    {
        $rows = [];
        foreach ($this->getIterable() as $item) {
            unset($item[$this->childKey]);
            $rows[] = $item;
        }

        return $rows;
    }

    /**
     * 返回树数组
     * @return array
     */
    public function toArray(): array
    {
        return $this->tree;
    }
}