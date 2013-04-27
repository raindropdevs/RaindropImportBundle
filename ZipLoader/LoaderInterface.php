<?php

namespace Raindrop\ImportBundle\ZipLoader;

use Raindrop\ImportBundle\Zip;
use Raindrop\ImportBundle\Exception\InvalidResourceException;

/**
 * LoaderInterface.
 */
interface LoaderInterface
{
    /**
     * Loads a zip that contains import datas.
     *
     * @param mixed $resource A resource
     *
     * @return Zip A Zip instance
     *
     * @api
     *
     * @throws NotFoundResourceException when the resource cannot be found
     * @throws InvalidResourceException  when the resource cannot be loaded
     */
    public function load($resource);
}
