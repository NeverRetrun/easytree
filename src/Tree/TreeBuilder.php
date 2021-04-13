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
     * 是否允许父级字段不存在
     * @var bool
     */
    protected $isAllowParentKeyNotExist = false;

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
        $nodes[$this->rootId] = new Node($this->rootId, null, $emptyData, [], $this->childrenKey);

        foreach ($this->originData as $nodeData) {
            if ($this->dataAdapter !== null) {
                $adapterNodeData = new $this->dataAdapter($nodeData);
            } else {
                $adapterNodeData = DefaultAdapter::source($nodeData);
            }

            $nodes[$adapterNodeData[$this->idKey]] = new Node(
                $adapterNodeData[$this->idKey],
                $adapterNodeData[$this->parentKey],
                $adapterNodeData,
                $adapterNodeData,
                $this->childrenKey
            );

            if (isset($children[$adapterNodeData[$this->parentKey]])) {
                $children[$adapterNodeData[$this->parentKey]][] = $adapterNodeData[$this->idKey];
            } else {
                $children[$adapterNodeData[$this->parentKey]] = [$adapterNodeData[$this->idKey]];
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
                    if ($this->isAllowParentKeyNotExist === false) {
                        throw new InvalidParentId("Node with ID {$id} points to non-existent parent with ID {$pid}");
                    }

                    $nodes[$this->rootId]->addChild($nodes[$id]);
                }
            }
        }

        return new Tree($nodes, $this);
    }

    /**
     * @param callable|Closure|null $beforeEach
     * @return TreeBuilder
     */
    public function setBeforeEach($beforeEach): TreeBuilder
    {
        $this->beforeEach = $beforeEach;
        return $this;
    }

    /**
     * 允许父级字段不存在
     * @return $this
     */
    public function allowParentKeyNotExist():TreeBuilder
    {
        $this->isAllowParentKeyNotExist = true;
        return $this;
    }

    /**
     * 不允许父级字段不存在
     * @return $this
     */
    public function notAllowParentKeyNotExist():TreeBuilder
    {
        $this->isAllowParentKeyNotExist = false;
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