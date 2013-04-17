<?php

namespace Raindrop\ImportBundle\Zip;

use Symfony\Component\Config\Resource\ResourceInterface;

/**
 * ZipCatalogueInterface
 */
interface ZipCatalogueInterface 
{
    /**
     * Gets the catalogue locale.
     *
     * @return string The locale
     *
     * @api
     */
    public function getLocale();
    
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
}
