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
}
