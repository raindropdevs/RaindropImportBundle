<?php

namespace Raindrop\ImportBundle\Zip;

use Raindrop\ImportBundle\Zip\Zip;

/**
 * ZipCatalogueInterface
 */
interface ZipCatalogueInterface
{
    /**
     * Gets the zip files within a given index.
     *
     * If $index is null, it returns all Zip objects.
     *
     * @param string $index The array index
     *
     * @return array An array of Zip objects
     *
     * @api
     */
    public function all($index = null);

    /**
     * Gets a zip.
     *
     * @param string $index The Zip object index
     *
     * @return string The zip
     *
     * @api
     */
    public function get($index);

    /**
     * Sets a Zip object for a given index.
     *
     * @param array  $zip   A Zip object
     * @param string $index The array index
     *
     * @api
     */
    public function replace($zip, $index);

    /**
     * Adds zip for a given index.
     *
     * @param array  $zip   A Zip object
     * @param string $index The array index
     *
     * @api
     */
    public function add($zip, $index);
}
