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
    private $resource;
    private $config;
    private $zip;

    /**
     * Constructor.
     *
     * @param string $destination
     * @param string $csvExtension
     * @param string $ymlExtension
     * @param string $zipExtension
     */
    public function __construct($destination = '/tmp/', $csvExtension = 'csv', $ymlExtension = 'yml', $zipExtension = 'zip')
    {
        $this->destination = $destination;
        $this->resource = $csvExtension;
        $this->config = $ymlExtension;
        $this->zip = $zipExtension;
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

            $zipFileInfo = pathinfo($resource);
            $destination = $this->destination . $zipFileInfo['filename'];

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
                // get file info
                $fileInfo = pathinfo($file->getPathName());

                // add resources, config and media files to Zip obj
                switch ($fileInfo['extension']) {
                    case $this->resource:
                        $zipFile->addResource($file->getPathName());
                        break;
                    case $this->config:
                        $zipFile->setConfig($file->getPathName());
                        break;
                    case $this->zip:
                        $zipFile->setMedia($file->getPathName());

                        // extract media files
                        $path = $destination . '/media';
                        $zipFile->extractMedia($path);
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
