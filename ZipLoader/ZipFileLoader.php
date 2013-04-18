<?php

namespace Raindrop\ImportBundle\ZipLoader;

use Raindrop\ImportBundle\Zip\Zip;
use Raindrop\ImportBundle\Zip\ZipCatalogue;
use Symfony\Component\Finder\Finder;

/**
 * ZipLoader
 */
class ZipFileLoader implements LoaderInterface
{
    private $destination = '/tmp';
    private $csv = 'csv';
    private $yml = 'yml';
    private $zip = 'zip';

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function load($resource, $locale, $category)
    {
        $zip = new \ZipArchive;

        if ($zip->open($resource) === TRUE) {

            $zipFileInfo = pathinfo($resource);
            $destination = $this->destination . $zipFileInfo['filename'];

            // extract zip file
            $zip->extractTo($destination);
            $zip->close();            

            // new Zip obj
            $zipFile = new Zip;

            // parse resource files
            $finder = new Finder();
            $finder->files()->in($destination);

            foreach ($finder as $file) {
                // get file info
                $fileInfo = pathinfo($file->getPathName());

                // add resources, config and media files to Zip obj
                switch ($fileInfo['extension']) {
                    case $this->csv:
                        $zipFile->addResource($file->getPathName());
                        break;
                    case $this->yml:
                        $zipFile->setConfig($file->getPathName());
                        break;
                    case $this->zip:
                        $zipFile->setMedia($file->getPathName());
                        break;
                    default:
                        break;
                }
            }

            
            $catalogue = new ZipCatalogue;
            $catalogue->add($zipFile, $category);
//            var_dump($catalogue);

            return $catalogue;
        } else {
            return false;
        }
    }
}
