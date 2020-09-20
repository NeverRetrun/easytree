<?php declare(strict_types=1);


namespace EasyTree\Tree;


use Closure;
use EasyTree\Adapter\AbstractAdapter;

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
}