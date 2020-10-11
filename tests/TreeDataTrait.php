<?php declare(strict_types=1);


trait TreeDataTrait
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
}