<?php

namespace Raindrop\ImportBundle\ZipLoader;

use Raindrop\ImportBundle\Zip\Zip;
use Symfony\Component\Finder\Finder;

/**
 * ZipLoader
 */
class ZipFileLoader implements LoaderInterface
{
    private $destination;
    private $resourceExtension;
    private $configExtension;
    private $zipExtension;

    /**
     * Constructor.
     *
     * @param string $destination
     * @param string $resourceExtension
     * @param string $configurationExtension
     * @param string $mediaExtension
     */
    public function __construct($destination = '/tmp', $resourceExtension = 'csv', $configurationExtension = 'yml', $mediaExtension = 'zip')
    {
        $this->destination = $destination;
        $this->resourceExtension = $resourceExtension;
        $this->configExtension = $configurationExtension;
        $this->zipExtension = $mediaExtension;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function load($resource)
    {
        $zip = new \ZipArchive;

        if ($zip->open($resource) === TRUE) {

            $destination = $this->destination . DIRECTORY_SEPARATOR . 'zip';

            // delete old tmp files
            $this->deleteDirectory($destination . DIRECTORY_SEPARATOR);

            // extract zip file
            $zip->extractTo($destination);
            $zip->close();

            // new Zip obj
            $zipFile = new Zip;

            // parse resource files
            $finder = new Finder();
            $finder->files()->in($destination);

            foreach ($finder as $file) {

                // add resources, config and media files to Zip obj
                switch ($file->getExtension()) {
                    case $this->resourceExtension:
                        $zipFile->addResource($file->getPathName());
                        break;
                    case $this->configExtension:
                        $zipFile->setConfig($file->getPathName());
                        break;
                    case $this->zipExtension:
                        $zipFile->setMedia($file->getPathName());
                        break;
                    default:
                        break;
                }
            }

            return $zipFile;
        } else {
            return false;
        }
    }

    // remove all files/subfolders recursively from a directory
    public function deleteDirectory($targ)
    {
        if (file_exists($targ)) {
            if (is_dir($targ)) {
                $files = glob($targ . '*', GLOB_MARK);
                foreach ($files as $file) {
                    $this->deleteDirectory($file);
                }
                rmdir($targ);
            } else {
                unlink($targ);
            }
        }
    }
}
