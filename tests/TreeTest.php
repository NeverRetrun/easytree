<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use EasyTree\Tree\Tree;

final class TreeTest extends TestCase
{
    public array $foo = [
        ['id' => 1, 'name' => '食物', 'parent_id' => 0],
        ['id' => 2, 'name' => '车辆', 'parent_id' => 0],
        ['id' => 3, 'name' => '面条', 'parent_id' => 1],
        ['id' => 4, 'name' => '饮料', 'parent_id' => 1],
        ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4],
        ['id' => 6, 'name' => '校车', 'parent_id' => 2],
    ];

    public function testTreeToRow()
    {
        $this->assertSame(
            $this->foo,
            (new Tree($this->foo))
                ->setUniquelyKey('id')
                ->generate()
                ->toRow()
        );
    }

    public function testTreeGenerate()
    {
        $this->assertEquals(
            [
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
                ]
            ],
            (new Tree($this->foo))
                ->setUniquelyKey('id')
                ->generate()
                ->toArray()
        );
    }
}