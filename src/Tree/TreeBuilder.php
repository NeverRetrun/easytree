<?php declare(strict_types=1);


namespace EasyTree\Tree;


use Closure;
use EasyTree\Adapter\AbstractAdapter;
use EasyTree\Adapter\DefaultAdapter;
use EasyTree\Exception\InvalidParentId;

class TreeBuilder
{
    /**
     * 原始数据
     * @var array
     */
    protected $originData;

    /**
     * 行数据唯一id key
     * @var string $idKey
     */
    protected $idKey = 'id';

    /**
     * 行数据父级id key
     * @var string
     */
    protected $parentKey = 'parent_id';

    /**
     * 行数据子集key
     * @var string
     */
    protected $childrenKey = 'children';

    /**
     * @var int | string
     */
    protected $rootId = 0;

    /**
     * 前置事件
     * @var callable | Closure | null
     */
    protected $beforeEach = null;

    /**
     * 数据适配器
     * @var null | AbstractAdapter
     */
    protected $dataAdapter = null;

    /**
     * TreeBuilder constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->originData = $data;
    }

    public function build(): Tree
    {
        if ($this->beforeEach !== null) {
            foreach ($this->originData as $key => $value) {
                call_user_func($this->beforeEach, $value, $key);
            }
        }

        $nodes                = $children = [];
        $emptyData            = DefaultAdapter::source([]);
        $nodes[$this->rootId] = new Node($this->rootId, null, $emptyData, []);

        foreach ($this->originData as $nodeData) {
            if ($this->dataAdapter !== null) {
                $adapterNodeData = new $this->dataAdapter($nodeData);
            } else {
                $adapterNodeData = DefaultAdapter::source($nodeData);
            }

            $nodes[$nodeData[$this->idKey]] = new Node(
                $nodeData[$this->idKey],
                $nodeData[$this->parentKey],
                $adapterNodeData,
                $nodeData
            );

            if (isset($children[$nodeData[$this->parentKey]])) {
                $children[$nodeData[$this->parentKey]][] = $nodeData[$this->idKey];
            } else {
                $children[$nodeData[$this->parentKey]] = [$nodeData[$this->idKey]];
            }
        }

        // 父级追加子节点
        foreach ($children as $pid => $childIds) {
            foreach ($childIds as $id) {
                if (isset($nodes[$pid])) {
                    if ($pid === $id) {
                        throw new InvalidParentId("Node with ID {$id} references its own ID as parent ID");
                    }
                    $nodes[$pid]->addChild($nodes[$id]);
                } else {
                    throw new InvalidParentId("Node with ID {$id} points to non-existent parent with ID {$pid}");
                }
            }
        }

        return new Tree($nodes, $this);
    }

    /**
     * @param callable|Closure|null $beforeEach
     * @return TreeBuilder
     */
    public function setBeforeEach($beforeEach)
    {
        $this->beforeEach = $beforeEach;
        return $this;
    }


    /**
     * @param AbstractAdapter|null $dataAdapter
     * @return TreeBuilder
     */
    public function setDataAdapter(?AbstractAdapter $dataAdapter): TreeBuilder
    {
        $this->dataAdapter = $dataAdapter;
        return $this;
    }

    /**
     * @param string $idKey
     * @return TreeBuilder
     */
    public function setIdKey(string $idKey): TreeBuilder
    {
        $this->idKey = $idKey;
        return $this;
    }

    /**
     * @param string $parentKey
     * @return TreeBuilder
     */
    public function setParentKey(string $parentKey): TreeBuilder
    {
        $this->parentKey = $parentKey;
        return $this;
    }

    /**
     * @param string $childrenKey
     * @return TreeBuilder
     */
    public function setChildrenKey(string $childrenKey): TreeBuilder
    {
        $this->childrenKey = $childrenKey;
        return $this;
    }

    /**
     * @param int|string $rootId
     * @return TreeBuilder
     */
    public function setRootId($rootId)
    {
        $this->rootId = $rootId;
        return $this;
    }

    /**
     * @return string
     */
    public function getChildrenKey(): string
    {
        return $this->childrenKey;
    }

    /**
     * @return int|string
     */
    public function getRootId()
    {
        return $this->rootId;
    }
}