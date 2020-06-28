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

    public function testCountMaxChildrenHeight()
    {
        $node = new \EasyTree\TreeNode\TreeNode(
            $this->foo,
            1,
            [
                new EasyTree\TreeNode\TreeNode($this->foo['children'][0], 2, [])
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
            [
                new EasyTree\TreeNode\TreeNode($this->foo['children'][0], 2, [])
            ]
        ))->toTree();

        $this->assertInstanceOf(
            \EasyTree\Tree\TreeInterface::class,
            $tree
        );
    }
}