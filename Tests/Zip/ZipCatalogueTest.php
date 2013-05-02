<?php

namespace Raindrop\ImportBundle\Tests\Zip;

use Raindrop\ImportBundle\Zip\ZipCatalogue;

/**
 * ZipCatalogueTest
 */
class ZipCatalogueTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->zip = $this->getZipMock();
        $this->mockZip = new MockZip();
        $this->anotherMockZip = new MockZip();
    }

    public function testAll()
    {
        $catalogue = new ZipCatalogue($zips = array($this->zip));

        $this->assertEquals($this->zip, $catalogue->all(0));
        $this->assertEquals(array(), $catalogue->all(1));
        $this->assertEquals($zips, $catalogue->all());
    }

    public function testGet()
    {
        $catalogue = new ZipCatalogue(array($this->getZipMock(), $this->mockZip));

        $this->assertEquals($this->zip, $catalogue->get(0));
        $this->assertEquals($this->mockZip, $catalogue->get(1));
    }

    public function testAdd()
    {
        $catalogue = new ZipCatalogue(array($this->getZipMock(), $this->mockZip));

        $catalogue->add($this->anotherMockZip, 2);
        $this->assertEquals($this->zip, $catalogue->get(0));
        $this->assertEquals($this->anotherMockZip, $catalogue->get(2));

        $catalogue->add($this->anotherMockZip, 1);
        $this->assertEquals($this->zip, $catalogue->get(0));
        $this->assertEquals($this->anotherMockZip, $catalogue->get(1));
    }

    public function testReplace()
    {
        $catalogue = new ZipCatalogue(array($this->getZipMock(), $this->mockZip));
        $catalogue->replace($this->anotherMockZip, 0);

        $this->assertEquals($this->anotherMockZip, $catalogue->get(0));
    }

    public function getZipMock()
    {
        return $this->getMock('Raindrop\ImportBundle\Zip\Zip');
    }
}

class MockZip
{

}
