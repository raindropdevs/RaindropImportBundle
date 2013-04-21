<?php

namespace Raindrop\ImportBundle\Tests\Import;

/**
 * Base class for Adapter test cases
 */
abstract class AdapterTestCase extends \PHPUnit_Framework_TestCase
{
    protected $adapter;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockEntityRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapter->setEntityRepository($this->mockEntityRepository);
    }
}
