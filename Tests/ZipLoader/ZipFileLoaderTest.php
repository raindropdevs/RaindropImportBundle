<?php

namespace Raindrop\ImportBundle\Tests\ZipLoader;

use Raindrop\ImportBundle\ZipLoader\ZipFileLoader;

/**
 * ZipFileLoaderTest
 */
class ZipFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $zip = __DIR__.'/../fixtures/zip.zip';
        $zipLoader = new ZipFileLoader;

        $this->assertInstanceOf('\Raindrop\ImportBundle\Zip\ZipCatalogue', $zipLoader->load($zip, 'es', 'category1'));
    }

    public function testLoadThatFails()
    {
        $zip = __DIR__.'/../fixtures/wrong.zip';
        $zipLoader = new ZipFileLoader;

        $this->assertFalse($zipLoader->load($zip, 'en', 'category1'));
    }

    public function getZipCatalogueMock()
    {
        return $this->getMock('\Raindrop\ImportBundle\Zip\ZipCatalogue');
    }
}
