<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use EasyTree\Tree\Tree;

final class TreeTest extends TestCase
{
    public $foo = [
        ['id' => 1, 'name' => '食物', 'parent_id' => 0],
        ['id' => 2, 'name' => '车辆', 'parent_id' => 0],
        ['id' => 3, 'name' => '面条', 'parent_id' => 1],
        ['id' => 4, 'name' => '饮料', 'parent_id' => 1],
        ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4],
        ['id' => 6, 'name' => '校车', 'parent_id' => 2],
    ];

    public $fooSubset = [
        ['id' => 1, 'name' => '食物', 'parent_id' => 0, 'subset' => 2],
        ['id' => 2, 'name' => '车辆', 'parent_id' => 0, 'subset' => 1],
        ['id' => 3, 'name' => '面条', 'parent_id' => 1, 'subset' => 0],
        ['id' => 4, 'name' => '饮料', 'parent_id' => 1, 'subset' => 1],
        ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4, 'subset' => 0],
        ['id' => 6, 'name' => '校车', 'parent_id' => 2, 'subset' => 0],
    ];

    public $fooTree = [
        [
            'id'       => 1,
            'name'     => '食物',
            'children' => [
                [
                    'id'   => 3,
                    'name' => '面条',
                ],
                [
                    'id'       => 4,
                    'name'     => '饮料',
                    'children' => [
                        [
                            'id'   => 5,
                            'name' => '矿泉水'
                        ],
                    ]
                ],
            ],
        ],
        [
            'id'       => 2,
            'name'     => '车辆',
            'children' => [
                [
                    'id'   => 6,
                    'name' => '校车'
                ],
            ]
        ],
    ];


    /**
     * 测试生成树 返回行
     */
    public function testTreeToRow()
    {
        $this->assertEquals(
            self::sort($this->foo),
            self::sort(
                (new Tree($this->foo))
                    ->setUniquelyKey('id')
                    ->generate(true)
                    ->toRow()
            )
        );
    }

    /**
     * 测试追加子集字段
     */
    public function testAppendSubsetCount()
    {
        $this->assertEquals(
            self::sort($this->fooSubset),
            self::sort(
                (new Tree($this->fooSubset))
                    ->setUniquelyKey('id')
                    ->generate(true)
                    ->appendSubsetCount()
                    ->toRow()
            )
        );
    }

    /**
     * 测试生成树 返回树数组
     */
    public function testTreeGenerate()
    {
        $this->assertEquals(
            json_encode($this->fooTree, JSON_UNESCAPED_UNICODE),
            json_encode(
                (new Tree($this->foo))
                    ->setUniquelyKey('id')
                    ->generate()
                    ->toArray()
                , JSON_UNESCAPED_UNICODE
            )
        );
    }

    public function testFrom()
    {
        $this->assertInstanceOf(
            \EasyTree\Tree\TreeInterface::class,
            Tree::from($this->fooTree)
        );
    }

    public function testGetIterable()
    {
        $tree = (new Tree($this->foo))
            ->setUniquelyKey('id')
            ->generate();

        $this->assertIsIterable($tree->getIterable());
    }

    public function testSetNodeTree()
    {
        $tree = (new Tree($this->foo))
            ->setUniquelyKey('id')
            ->generate()
            ->setNodeTree();

        $nodeTree = $tree->getNodeTree();

        foreach ($tree->getIterable($nodeTree) as $node) {
            $this->assertInstanceOf(
                \EasyTree\TreeNode\TreeNode::class,
                $node
            );
        }
    }

    public function testSearchNode()
    {
        $node = (new Tree($this->foo))
            ->setUniquelyKey('id')
            ->generate()
            ->searchNode('id', 5);

        $this->assertInstanceOf(
            \EasyTree\TreeNode\TreeNode::class,
            $node
        );

        $this->assertEquals(
            ['id' => 5, 'name' => '矿泉水'],
            $node->data
        );
    }

    public function testSearchNodes()
    {
        $nodes = (new Tree($this->foo))
            ->setUniquelyKey('id')
            ->generate()
            ->searchNodes('name', ['食物', '饮料', '矿泉水']);

        $this->assertEquals(
            $this->fooTree[0],
            $nodes[0]->data
        );

        $this->assertEquals(
            $this->fooTree[0]['children'][1],
            $nodes[1]->data
        );

        $this->assertEquals(
            $this->fooTree[0]['children'][1]['children'][0],
            $nodes[2]->data
        );
    }

    public function testSearchNodePath()
    {
        $nodes = (new Tree($this->foo))
            ->setUniquelyKey('id')
            ->generate()
            ->searchNodePath('id', 5);

        $this->assertEquals(
            $this->fooTree[0]['children'][1]['children'][0],
            $nodes[0]->data
        );

        $this->assertEquals(
            $this->fooTree[0]['children'][1],
            $nodes[1]->data
        );

        $this->assertEquals(
            $this->fooTree[0],
            $nodes[2]->data
        );
    }

    /**
     * 比较2个 数组相同所需的排序
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function sort(array $array, string $key = 'id'): array
    {
        uasort($array, function ($a, $b) use ($key) {
            return $a[$key] <=> $b[$key];
        });

        return array_values($array);
    }
}