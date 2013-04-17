<?php

namespace Raindrop\ImportBundle\Tests\Zip;

use Raindrop\ImportBundle\Zip\ZipCatalogue;

/**
 * ZipCatalogueTest
 */
class ZipCatalogueTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLocale()
    {
        $catalogue = new ZipCatalogue('en');

        $this->assertEquals('en', $catalogue->getLocale());
    }
    
    public function testGetCategories()
    {
        $catalogue = new ZipCatalogue('en', array('domain1' => array(), 'domain2' => array()));

        $this->assertEquals(array('domain1', 'domain2'), $catalogue->getCategories());
    }   
    
    public function testAll()
    {
        $catalogue = new ZipCatalogue('en', $zips = array('domain1' => array('foo' => 'foo'), 'domain2' => array('bar' => 'bar')));

        $this->assertEquals(array('foo' => 'foo'), $catalogue->all('domain1'));
        $this->assertEquals(array(), $catalogue->all('domain88'));
        $this->assertEquals($zips, $catalogue->all());
    }    
}
