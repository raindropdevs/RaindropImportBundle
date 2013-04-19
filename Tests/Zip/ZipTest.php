<?php

namespace Raindrop\ImportBundle\Tests\Zip;

use Raindrop\ImportBundle\Zip\Zip;

/**
 * ZipTest
 */
class ZipTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->resources = array(__DIR__.'/../fixtures/resources.csv');
        $this->config = __DIR__.'/../fixtures/resources.yml';
        $this->media = __DIR__.'/../fixtures/media.zip';
    }

    public function testGetResources()
    {
        $zip = new Zip($this->resources, $this->media, $this->config);
        $this->assertEquals($this->resources, $zip->getResources());
    }

    public function testGetConfig()
    {
        $zip = new Zip($this->resources, $this->media, $this->config);
        $this->assertEquals($this->config, $zip->getConfig());
    }

    public function testGetMedia()
    {
        $zip = new Zip($this->resources, $this->media, $this->config);
        $this->assertEquals($this->media, $zip->getMedia());
    }

    public function testAddResource()
    {
        $zip = new Zip($this->resources, $this->media, $this->config);
        $zip->addResource(__DIR__.'/../fixtures/empty.csv');
        $this->assertEquals(array(
                __DIR__.'/../fixtures/resources.csv',
                __DIR__.'/../fixtures/empty.csv'
            ),
            $zip->getResources());
    }

    public function testSetConfig()
    {
        $zip = new Zip($this->resources, $this->media);
        $zip->setConfig($this->config);
        $this->assertEquals($this->config, $zip->getConfig());
    }

    public function testSetMedia()
    {
        $zip = new Zip($this->resources);
        $zip->setMedia($this->media);
        $this->assertEquals($this->media, $zip->getMedia());
    }
}
