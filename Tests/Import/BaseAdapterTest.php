<?php

namespace Raindrop\ImportBundle\Tests\Import;

use Raindrop\ImportBundle\Tests\Fixtures\TestEntity;
use Raindrop\ImportBundle\Import\BaseAdapter;

/**
 * BaseAdapterTest
 */
class BaseAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockEntityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapter = new MockAdapter();
        $this->adapter->setEntityRepository($this->mockEntityRepository);
        $this->adapter->setEntityName('Raindrop\ImportBundle\Tests\Fixtures\TestEntity');
    }

    /**
     * Testing base adapter
     */
    public function testFind()
    {
        $params = array('foo' => 'dummy');

        $this->mockEntityRepository->expects($this->once())
            ->method('findOneBy')
            ->with($params)
            ->will($this->returnValue(null));

        $object = $this->adapter->find($params);

        $this->assertNull($object->getId());
    }

    /**
     * Testing success case
     */
    public function testFindSuccess()
    {
        $params = array('foo' => 'dummy');

        $objectExpected = new TestEntity();
        $objectExpected->setField1('fooName');

        $this->mockEntityRepository->expects($this->once())
            ->method('findOneBy')
            ->with($params)
            ->will($this->returnValue($objectExpected));

        $object = $this->adapter->find($params);

        $this->assertEquals($objectExpected, $object);
        $this->assertEquals('fooName', $object->getField1());
    }
}

class MockAdapter extends BaseAdapter
{
    /**
     * {@inheritDoc}
     */
    public function import($row)
    {
    }
}
