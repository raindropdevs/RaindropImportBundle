<?php

namespace Raindrop\ImportBundle\Zip;

/**
 * ZipCatalogueInterface
 */
interface ZipCatalogueInterface
{
    /**
     * Gets the categories.
     *
     * @return array An array of categories
     *
     * @api
     */
    public function getCategories();

    /**
     * Gets the zip files within a given category.
     *
     * If $category is null, it returns all zip.
     *
     * @param string $category The category name
     *
     * @return array An array of zip files
     *
     * @api
     */
    public function all($category = null);

    /**
     * Sets a zip.
     *
     * @param string $id       The zip id
     * @param string $zip      The zip
     * @param string $category The category name
     *
     * @api
     */
    public function set($id, $zip, $category);

    /**
     * Gets a zip.
     *
     * @param string $id       The zip id
     * @param string $category The category name
     *
     * @return string The zip
     *
     * @api
     */
    public function get($id, $category);

    /**
     * Sets zips for a given category.
     *
     * @param array  $zips     An array of zips
     * @param string $category The category name
     *
     * @api
     */
    public function replace($zips, $category);

    /**
     * Adds zip for a given category.
     *
     * @param array  $zips     An array of zips
     * @param string $category The domain name
     *
     * @api
     */
    public function add($zips, $category);
}
