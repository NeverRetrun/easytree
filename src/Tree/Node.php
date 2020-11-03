<?php declare(strict_types=1);


namespace EasyTree\Tree;


use EasyTree\Adapter\AbstractAdapter;

class Node
{
    /**
     * id
     * @var int | string
     */
    protected $id;

    /**
     * 父级id
     * @var int | string | null
     */
    protected $parentId;

    /**
     * @var AbstractAdapter
     */
    protected $data;

    /**
     * @var Node | null
     */
    protected $parent;

    /**
     * @var Node[]
     */
    protected $children = [];

    /**
     * @var mixed
     */
    protected $originData;

    /**
     * @var string
     */
    protected $childrenKey;

    public function __construct(
        $id,
        $parentId,
        AbstractAdapter $adapterData,
        $originData,
        string $childrenKey
    )
    {
        $this->id          = $id;
        $this->parentId    = $parentId;
        $this->data        = $adapterData;
        $this->originData  = $originData;
        $this->childrenKey = $childrenKey;
    }

    /**
     * 追加子节点
     * @param Node $child
     */
    public function addChild(Node $child): void
    {
        $this->children[] = $child;
        $child->parentId  = $this->getId();
        $child->parent    = $this;
    }

    /**
     * @param bool $isIncludeChildren
     * @return array
     */
    public function toArray(bool $isIncludeChildren = true): array
    {
        if ($this->hasChildren() === false) {
            return $this->data->toArray();
        }

        $node = $this->data->toArray();
        if ($isIncludeChildren) {
            $node[$this->childrenKey] = [];
            foreach ($this->children as $childrenNode) {
                $node[$this->childrenKey][] = $childrenNode->toArray();
            }
        }

        return $node;
    }

    /**
     * @param TreeBuilder $treeBuilder
     * @return Tree
     */
    public function toTree(TreeBuilder $treeBuilder): Tree
    {
        $treeBuilder->setRootId($this->id);

        return new Tree(
            [$this->getId() => $this]
            , $treeBuilder
        );
    }

    /**
     * 获取等级
     * @return int
     */
    public function getLevel(): int
    {
        if ($this->parent !== null) {
            return $this->parent->getLevel() + 1;
        } else {
            return 0;
        }
    }

    /**
     * 获取节点最大等级
     * @return int
     */
    public function getMaxLevel(): int
    {
        $level = $this->getLevel();

        if ($this->hasChildren()) {
            foreach ($this->children as $child) {
                $childLevel = $child->getMaxLevel();
                if ($childLevel > $level) {
                    $level = $childLevel;
                }
            }
        }

        return $level;
    }

    /**
     * 获取树遍历器
     *
     * foreach ($node->getChildrenIterable() as $node) 的方式遍历
     * 节点与该子节点数据。
     *
     * @return iterable
     */
    public function getChildrenIterable(): iterable
    {
        foreach ($this->children as $node) {
            yield $node;

            foreach ($node->getChildrenIterable() as $childrenNode) {
                yield $childrenNode;
            }
        }
    }

    /**
     * 判断是否有子集
     * @return bool
     */
    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    /**
     * 获取子集个数
     * @return int
     */
    public function countChildren(): int
    {
        return count($this->children);
    }


    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @return AbstractAdapter
     */
    public function getData(): AbstractAdapter
    {
        return $this->data;
    }

    /**
     * @return Node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * @return Node[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}