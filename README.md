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
$ composer require cvoid/easytree  -vvv
```

### Usage

---

* 基本由普通的行结构转成树结构

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


* 你可以进行搜索节点，这里提供了3种搜索方式

   * 搜索单个节点

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

   * 查询单个节点，保存查询路径

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

* 你可以有个轻松的方式来循环树。`each`方法遍历树。

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

   



### License

---

MIT