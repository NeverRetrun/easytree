<?php

require_once './vendor/autoload.php';


$test = [
    ['id' => 1, 'name' => '食物', 'parent_id' => 0],
    ['id' => 2, 'name' => '车辆', 'parent_id' => 0],
    ['id' => 3, 'name' => '面条', 'parent_id' => 1],
    ['id' => 4, 'name' => '饮料', 'parent_id' => 1],
    ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4],
    ['id' => 6, 'name' => '校车', 'parent_id' => 2],
];

$tree = (new \EasyTree\Tree\Tree($test))
    ->setUniquelyKey('id')
    ->generate(false);

//var_dump($tree->searchNode('name', '面条'));
var_dump($tree->searchNodePath('id', 5));

