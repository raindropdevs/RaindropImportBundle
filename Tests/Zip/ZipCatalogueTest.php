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
        $catalogue = new ZipCatalogue('en', array('category1' => array(), 'category2' => array()));

        $this->assertEquals(array('category1', 'category2'), $catalogue->getCategories());
    }

    public function testAll()
    {
        $catalogue = new ZipCatalogue('en', $zips = array('category1' => array('foo' => 'foo'), 'category2' => array('bar' => 'bar')));

        $this->assertEquals(array('foo' => 'foo'), $catalogue->all('category1'));
        $this->assertEquals(array(), $catalogue->all('category88'));
        $this->assertEquals($zips, $catalogue->all());
    }

    public function testGetSet()
    {
        $catalogue = new ZipCatalogue('en', array('category1' => array('foo' => 'foo'), 'category2' => array('bar' => 'bar')));
        $catalogue->set('foo1', 'foo1', 'category1');

        $this->assertEquals('foo', $catalogue->get('foo', 'category1'));
        $this->assertEquals('foo1', $catalogue->get('foo1', 'category1'));
    }

    public function testAdd()
    {
        $catalogue = new ZipCatalogue('en', array('category1' => array('foo' => 'foo'), 'category2' => array('bar' => 'bar')));
        $catalogue->add(array('foo1' => 'foo1'), 'category1');

        $this->assertEquals('foo', $catalogue->get('foo', 'category1'));
        $this->assertEquals('foo1', $catalogue->get('foo1', 'category1'));

        $catalogue->add(array('foo' => 'bar'), 'category1');
        $this->assertEquals('bar', $catalogue->get('foo', 'category1'));
        $this->assertEquals('foo1', $catalogue->get('foo1', 'category1'));

        $catalogue->add(array('foo' => 'bar'), 'category88');
        $this->assertEquals('bar', $catalogue->get('foo', 'category88'));
    }

    public function testReplace()
    {
        $catalogue = new ZipCatalogue('en', array('category1' => array('foo' => 'foo'), 'category2' => array('bar' => 'bar')));
        $catalogue->replace($messages = array('foo1' => 'foo1'), 'category1');

        $this->assertEquals($messages, $catalogue->all('category1'));
    }
}
