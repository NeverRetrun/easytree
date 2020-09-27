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

    public function __construct($id, $parentId, AbstractAdapter $adapterData, $originData)
    {
        $this->id         = $id;
        $this->parentId   = $parentId;
        $this->data       = $adapterData;
        $this->originData = $originData;
    }

    public function addChild(Node $child): void
    {
        $this->children[] = $child;
        $child->parentId  = $this->getId();
        $child->parent    = $this;
    }

    public function toArrayIncludeSelf(string $childrenKey): array
    {
        if ($this->hasChildren() === false) {
            return $this->data->toArray();
        }

        $node = $this->data->toArray();
        $node['children'] = [];
        foreach ($this->children as $childrenNode) {
            $node['children'][] = $childrenNode->toArrayIncludeSelf($childrenKey);
        }

        return $node;
    }

    public function getLevel(): int
    {
        if ($this->parent !== null) {
            return $this->parent->getLevel() + 1;
        }else {
            return 0;
        }
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    public function countChildren(): int
    {
        return count($this->children);
    }

    protected function getAncestorsGeneric(bool $includeSelf): array
    {

    }

    public function getAncestorsAndSelf(): array
    {

    }

    public function getAncestors(): array
    {

    }

    protected function getDescendantsGeneric(bool $includeSelf): array
    {

    }

    public function getDescendantsAndSelf(): array
    {

    }

    public function getDescendants(): array
    {

    }

    protected function getSiblingsGeneric(bool $includeSelf): array
    {

    }

    public function getSiblingsAndSelf(): array
    {

    }

    public function getSiblings(): array
    {

    }

    private function getSibling(int $offset): ?Node
    {

    }

    public function getFollowingSibling(): ?Node
    {

    }

    public function getPrecedingSibling(): ?Node
    {

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