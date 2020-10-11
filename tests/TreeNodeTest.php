<?php declare(strict_types=1);


use EasyTree\Adapter\DefaultAdapter;
use PHPUnit\Framework\TestCase;

final class TreeNodeTest extends TestCase
{
    use TreeDataTrait;

    protected $data = [
        'id'        => 1,
        'parent_id' => 2,
        'data'      => 'test',
    ];

    public function getNode()
    {
        return new \EasyTree\Tree\Node(
            1,
            2,
            DefaultAdapter::source($this->data),
            $this->data,
            'children'
        );
    }

    public function testToArray()
    {
        $this->assertEquals(
            $this->getNode()->toArray(),
            $this->data
        );
    }


}