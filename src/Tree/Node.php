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

    public function getLevel(): int
    {

    }

    public function hasChildren(): bool
    {

    }

    public function countChildren(): int
    {

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