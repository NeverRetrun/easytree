# EasyTree

* 主要用于将有父子关系的行结构数据整理成为树结构数据。

[![](https://img.shields.io/badge/PHP->=7.2-{徽标颜色}.svg)]() [![](https://img.shields.io/badge/ext-json-{徽标颜色}.svg)]() 



### Requirement

---

1. PHP >= 7.2
2. [Composer](https://getcomposer.org/)



### Installation

---

```bash
$ composer require "cvoid/easytree^2"  -vvv
```

### Usage

---

##### api

[toArray](#toArray) 转数组

[toJson](#toJson) 转json

[each](#each) 遍历树

[search](#search) 遍历树搜索符合条件的第一个值

[searchAll](#searchAll) 遍历树搜索符合条件的所有值

[contain](#contain) 判断是否包含某个值

[getChildTree](#getChildTree) 根据search出来的子节点构成一个新的树

[isOverLevel](#isOverLevel)  判断树是否超出高度

---



##### toArray

```php
<?php

require_once './vendor/autoload.php';

$foo = [
    ['id' => 1, 'name' => '食物', 'parent_id' => 0],
    ['id' => 4, 'name' => '饮料', 'parent_id' => 1],
    ['id' => 5, 'name' => '矿泉水', 'parent_id' => 4],
];

$tree = (new \EasyTree\Tree\TreeBuilder($foo))
    ->setIdKey('id')
    ->setParentKey('parent_id')
    ->setChildrenKey('children')
    ->build();

print_r($tree->toArray());

echo -----
Array
(
    [0] => Array
        (
            [id] => 1
            [name] => 食物
            [children] => Array
                (
                    [0] => Array
                        (
                            [id] => 4
                            [name] => 饮料
                            [children] => Array
                                (
                                    [0] => Array
                                        (
                                            [id] => 5
                                            [name] => 矿泉水
                                        )

                                )

                        )

                )

        )

)

```

##### toJson

```php
<?php
	$tree = (new \EasyTree\Tree\TreeBuilder($foo))
    	->setIdKey('id')
    	->setParentKey('parent_id')
    	->setChildrenKey('children')
    	->build();

	print_r($tree->toJson());

echo -----
[{"id":1,"name":"食物","parent_id":0,"children":[{"id":3,"name":"面条","parent_id":1},{"id":4,"name":"饮料","parent_id":1,"children":[{"id":5,"name":"矿泉水","parent_id":4}]}]},{"id":2,"name":"车辆","parent_id":0,"children":[{"id":6,"name":"校车","parent_id":2}]}]
```

#####each

```php
<?php
$tree = (new \EasyTree\Tree\TreeBuilder($foo))
	    ->setIdKey('id')
	    ->setParentKey('parent_id')
	    ->setChildrenKey('children')
	    ->build();

$tree->each(
   function($node) {
	   # dump node data
		var_dump($node);
	}
)
```

#####search

```php
<?php
  
	$tree = (new \EasyTree\Tree\TreeBuilder($foo))
    ->setIdKey('id')
    ->setParentKey('parent_id')
    ->setChildrenKey('children')
    ->build();
	
	#搜索节点id = 5的节点
	$node = $tree->search(
	function($node) {
		return $node->getId() === 5;
	}
);
	
  #搜索节点name = 矿泉水的节点
	$node = $tree->search(
	function($node) {
		return $node->getData()->toArray()['name'] === '矿泉水';
	}
);

	##你可以获取节点的高度 或者 数据
	$node->getData()->toArray();
  echo -----
    Array
		(
    		[id] => 5
    		[name] => 矿泉水
		)
    
  $node->getLevel();  
	echo -----
    3
```

#####searchAll

```php
<?php
$tree = (new \EasyTree\Tree\TreeBuilder($foo))
    ->setIdKey('id')
    ->setParentKey('parent_id')
    ->setChildrenKey('children')
    ->build();
 
$nodes = $tree->searchAll(
   function($node) {
     return $node->getParentId() === 1;
   }
);
 
print_r($nodes);
#这里会返回 [矿泉水TreeNode对象, 饮料TreeNode对象, 食品TreeNode对象]
```

##### contain

```php
<?php
  $tree = (new \EasyTree\Tree\TreeBuilder($foo))
      ->setIdKey('id')
      ->setParentKey('parent_id')
      ->setChildrenKey('children')
      ->build();

  var_dump(
      $tree->contain(function (\EasyTree\Tree\Node $node): bool {
          return $node->getData()['name'] === 1;
      })
  );
	
  var_dump(
      $tree->contain(function (\EasyTree\Tree\Node $node): bool {
          return $node->getData()['name'] === '校车';
      })
  );

echo ----
bool(false)
bool(true)
```

##### isOverLevel

```php
<?php
  $tree = (new \EasyTree\Tree\TreeBuilder($foo))
      ->setIdKey('id')
      ->setParentKey('parent_id')
      ->setChildrenKey('children')
      ->build();

  var_dump(
      $tree->isOverLevel(3)
  );

  var_dump(
      $tree->isOverLevel(4)
  );

echo ----
bool(false)
bool(true)
```

#####



### License

---

MIT