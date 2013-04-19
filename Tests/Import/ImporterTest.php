<?php

namespace Raindrop\ImportBundle\Tests\Import;

use Raindrop\ImportBundle\Util\CaseConverter;
use Raindrop\ImportBundle\Import\Importer;
use Raindrop\ImportBundle\Util\Reader;

/**
 * Test importer class
 */
class ImporterTest extends \PHPUnit_Framework_TestCase
{
    protected $fieldRetriever;
    protected $class;
    protected $fields;

    /**
     * Setup test class
     *
     * @return nothing
     */
    public function setUp()
    {
        $fields = array('id', 'field1', 'field2');

        $this->fields = $fields;

        $caseConverter = new CaseConverter();
        $reader = new Reader();

        $metadata = $this->getMockForAbstractClass('Doctrine\Common\Persistence\Mapping\ClassMetadata', array('hasField'));
        $metadata->expects($this->any())
            ->method('hasField')
            ->will($this->returnCallback(function($value) use ($fields) {
                return in_array($value, $fields);
            }));

        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($metadata));

        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $dispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnValue('true'));

        $this->importer = new Importer($reader, $dispatcher, $caseConverter, $objectManager, 5);

        $this->importer->init(__DIR__ . '/../Fixtures/import.csv', 'Raindrop\ImportBundle\Tests\Fixtures\TestEntity', ',', 'title');
    }

    /**
     * Test import
     */
    public function testImport()
    {
        $this->assertEquals(
            true,
            $this->importer->import($this->fields)
        );

        $this->assertEquals(
            3,
            $this->importer->getImportCount()
        );
    }
}
