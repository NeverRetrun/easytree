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
            'id'        => 1,
            'name'      => '食物',
            'parent_id' => 0,
            'children'  => [
                [
                    'id'        => 3,
                    'name'      => '面条',
                    'parent_id' => 1,
                ],
                [
                    'id'        => 4,
                    'name'      => '饮料',
                    'parent_id' => 1,
                    'children'  => [
                        [
                            'id'        => 5,
                            'name'      => '矿泉水',
                            'parent_id' => 4,
                        ],
                    ]
                ],
            ],
        ],
        [
            'id'        => 2,
            'name'      => '车辆',
            'parent_id' => 0,
            'children'  => [
                [
                    'id'        => 6,
                    'name'      => '校车',
                    'parent_id' => 2,
                ],
            ]
        ],
    ];

    public function getTree()
    {
        return (new \EasyTree\Tree\TreeBuilder($this->foo))
            ->setIdKey('id')
            ->setParentKey('parent_id')
            ->setChildrenKey('children')
            ->build();
    }

    public function searchOriginData($id)
    {
        foreach ($this->foo as $node) {
            if ($node['id'] === $id) {
                return $node;
            }
        }
        return null;
    }

    /**
     * 测试生成树 返回树数组
     */
    public function testTreeGenerate()
    {
        $this->assertEquals(
            json_encode($this->fooTree, JSON_UNESCAPED_UNICODE),
            json_encode($this->getTree()->toArray(), JSON_UNESCAPED_UNICODE)
        );
    }

    public function testEach()
    {
        $this->getTree()
            ->each(
                function (\EasyTree\Tree\Node $node) {
                    $originData = $node->getData()->toArray();
                    $this->assertEquals(
                        $this->searchOriginData($originData['id']),
                        $originData
                    );
                }
            );
    }

    public function testSearch()
    {
        $this->assertEquals(
            $this->getTree()
                ->search(
                    function (\EasyTree\Tree\Node $node) {
                        return $node->getId() === 2;
                    }
                )
                ->toArray(false),
            ['id' => 2, 'name' => '车辆', 'parent_id' => 0]
        );
    }

    public function testContain()
    {
        $this->assertEquals(
            $this->getTree()
                ->contain(
                    function (\EasyTree\Tree\Node $node) {
                        return $node->getId() === 4;
                    }
                ),
            true
        );

        $this->assertEquals(
            $this->getTree()
                ->contain(
                    function (\EasyTree\Tree\Node $node) {
                        return $node->getId() === 10;
                    }
                ),
            false
        );
    }

    public function testGetChildTree()
    {
        $this->assertEquals(
            $this->getTree()
                ->getChildTree(
                    function (\EasyTree\Tree\Node $node) {
                        return $node->getId() === 1;
                    }
                )->toArray(),

            [
                [
                    'id'        => 3,
                    'name'      => '面条',
                    'parent_id' => 1,
                ],
                [
                    'id'        => 4,
                    'name'      => '饮料',
                    'parent_id' => 1,
                    'children'  => [
                        [
                            'id'        => 5,
                            'name'      => '矿泉水',
                            'parent_id' => 4,
                        ],
                    ]
                ],
            ]
        );
    }

    public function testIsOverLevel()
    {
        $this->assertEquals(
            $this->getTree()->isOverLevel(3),
            false
        );

        $this->assertEquals(
            $this->getTree()->isOverLevel(4),
            true
        );
    }
}