<?php

namespace Raindrop\ImportBundle\Tests\ZipLoader;

use Raindrop\ImportBundle\ZipLoader\ZipFileLoader;

/**
 * ZipFileLoaderTest
 */
class ZipFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('ZipArchive')) {
            $this->markTestSkipped(
              'The ZipArchive extension is not available.'
            );
        }
    }

    public function testLoad()
    {
        $zip = __DIR__.'/../fixtures/zip.zip';
        $zipLoader = new ZipFileLoader;

        $this->assertInstanceOf('\Raindrop\ImportBundle\Zip\Zip', $zipLoader->load($zip));
    }

    public function testLoadThatFails()
    {
        $zip = __DIR__.'/../fixtures/wrong.zip';
        $zipLoader = new ZipFileLoader;

        $this->assertFalse($zipLoader->load($zip));
    }
}
