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
     * @var int | string
     */
    protected $parentId;

    /**
     * @var AbstractAdapter
     */
    protected $data;

    /**
     * @var Node
     */
    protected $parent;

    /**
     * @var Node[]
     */
    protected $children;

    public function __construct($id, $parentId, array $data)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->data = $data;
    }

    public function addChild(Node $child): void
    {
        $this->children[] = $child;
        $child->parentId = $this->getId();
        $child->parent = $this;
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