<?php

namespace Raindrop\ImportBundle\ZipLoader;

use Raindrop\ImportBundle\ZipCatalogue;
use Raindrop\ImportBundle\Exception\InvalidResourceException;

/**
 * LoaderInterface.
 */
interface LoaderInterface
{
    /**
     * Loads a zip that contains import datas.
     *
     * @param mixed  $resource A resource
     * @param string $locale   A locale
     * @param string $category The category of datas
     *
     * @return ZipCatalogue A ZipCatalogue instance
     *
     * @api
     *
     * @throws NotFoundResourceException when the resource cannot be found
     * @throws InvalidResourceException  when the resource cannot be loaded
     */
    public function load($resource, $locale, $category);
}
