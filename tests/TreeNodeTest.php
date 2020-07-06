<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;

final class TreeNodeTest extends TestCase
{
    public $foo = [
        'id'       => 4,
        'name'     => '饮料',
        'children' => [
            [
                'id'   => 5,
                'name' => '矿泉水'
            ],
        ]
    ];

    public function testGetUniquelyKeyData()
    {
        $this->assertEquals(
            4,
            (new \EasyTree\TreeNode\TreeNode(
                $this->foo,
                1,
                'id'
            ))->getUniquelyKeyData()
        );
    }

    public function testCountMaxChildrenHeight()
    {
        $node = new \EasyTree\TreeNode\TreeNode(
            $this->foo,
            1,
            'id',
            [
                new EasyTree\TreeNode\TreeNode($this->foo['children'][0], 2, 'id', [])
            ]
        );

        $this->assertEquals(
            2,
            $node->setMaxChildrenHeight()
                ->maxChildrenHeight
        );
    }


    public function testToTree()
    {
        $tree = (new \EasyTree\TreeNode\TreeNode(
            $this->foo,
            1,
            'id',
            [
                new EasyTree\TreeNode\TreeNode($this->foo['children'][0], 2, 'id', [])
            ]
        ))->toTree();

        $this->assertInstanceOf(
            \EasyTree\Tree\Tree::class,
            $tree
        );
    }
}