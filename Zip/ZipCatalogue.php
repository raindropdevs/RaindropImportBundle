<?php

namespace Raindrop\ImportBundle\Zip;

use Raindrop\ImportBundle\Zip\ZipCatalogueInterface;

/**
 * ZipCatalogue
 */
class ZipCatalogue implements ZipCatalogueInterface
{
    private $locale;
    private $zips = array();

    /**
     * Constructor.
     *
     * @param string $locale The locale
     * @param array  $zips   An array of zip files classified by domain
     *
     * @api
     */
    public function __construct($locale, array $zips = array())
    {
        $this->locale = $locale;
        $this->zips = $zips;
    }
    
    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getLocale()
    {
        return $this->locale;
    }    
    
    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getCategories()
    {
        return array_keys($this->zips);
    } 
    
    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function all($category = null)
    {
        if (null === $category) {
            return $this->zips;
        }

        return isset($this->zips[$category]) ? $this->zips[$category] : array();
    }    
}
