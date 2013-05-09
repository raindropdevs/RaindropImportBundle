<?php

namespace Raindrop\ImportBundle\Manager;

use Raindrop\ImportBundle\ZipLoader\ZipFileLoader;
use Raindrop\ImportBundle\Import\Importer;

use Raindrop\ImportBundle\Exception\NotFoundResourceException;

/**
 * Importer
 */
class Manager
{
    /**
     * @var Raindrop\ImportBundle\ZipLoader\ZipFileLoader
     */
    protected $zipFileLoader;

    /**
     * @var Raindrop\ImportBundle\Import\Importer
     */
    protected $importer;

    /**
     * @var string
     */
    protected $destination;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var array
     */
    protected $results;

    /**
     * Constructor.
     *
     * @param ZipFileLoader $zipFileLoader
     * @param Importer      $importer
     * @param string        $destination
     */
    public function __construct(ZipFileLoader $zipFileLoader, Importer $importer, $destination)
    {
        $this->zipFileLoader = $zipFileLoader;
        $this->importer = $importer;
        $this->destination = $destination;
    }

    /**
     * Import zip resource
     *
     * @param string $resource
     *
     * @return array
     */
    public function import($resource)
    {
        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

        /** @var \Raindrop\ImportBundle\Zip\Zip $zip */
        $zip = $this->zipFileLoader->load($resource);

        $config = $zip->getConfig();

        // extract media files
        $path = $this->destination . '/uploads/' . $config['path'];
        if (!file_exists($path)) mkdir($path, 0777, true);
        $zip->extractMedia($path);

        // import each resource file
        foreach ($zip->getResources() as $resource) {
            $this->importer->init($resource, $config);
            $this->results = $this->importer->import();
        }

        return $this->results;
    }
}
