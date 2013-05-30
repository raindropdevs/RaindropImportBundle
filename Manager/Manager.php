<?php

namespace Raindrop\ImportBundle\Manager;

use Raindrop\ImportBundle\ZipLoader\ZipFileLoader;
use Raindrop\ImportBundle\Import\Importer;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

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
    public function __construct(ZipFileLoader $zipFileLoader, ContainerInterface $container, $destination)
    {
        $this->zipFileLoader = $zipFileLoader;
        $this->container = $container;
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

        // retrieve adapter
        $adapterId = "collection.{$config['adapter']}.importer";
        if (!$this->container->has($adapterId)) {
            throw new \Exception("The type {$adapterId} is not found as a valid import manager");
        }
        $this->importer = $this->container->get($adapterId);

        if ($zip->getMedia()) {
            // extract media files
            $path = $this->destination . '/uploads/' . $config['path'];
            if (!file_exists($path)) mkdir($path, 0777, true);

            $zip->extractMedia($path);
        }

        // import each resource file
        foreach ($zip->getResources() as $resource) {
            $this->importer->init($resource, $config);
            $this->results = $this->importer->import();
        }

        return $this->results;
    }
}
