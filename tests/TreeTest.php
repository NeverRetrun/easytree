<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use EasyTree\Tree\Tree;

final class TreeTest extends TestCase
{
    use TreeDataTrait;

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