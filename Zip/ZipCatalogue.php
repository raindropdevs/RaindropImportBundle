<?php

namespace Raindrop\ImportBundle\Zip;

use Raindrop\ImportBundle\Zip\ZipCatalogueInterface;

/**
 * ZipCatalogue
 */
class ZipCatalogue implements ZipCatalogueInterface
{
    private $zips = array();

    /**
     * Constructor.
     *
     * @param array $zips An array of zip files classified by category
     *
     * @api
     */
    public function __construct(array $zips = array())
    {
        $this->zips = $zips;
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

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function set($id, $zip, $category)
    {
        $this->add(array($id => $zip), $category);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function get($id, $category)
    {
        if (isset($this->zips[$category][$id])) {
            return $this->zips[$category][$id];
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function replace($zips, $category)
    {
        $this->zips[$category] = array();

        $this->add($zips, $category);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function add($zips, $category)
    {
        if (!isset($this->zips[$category])) {
            $this->zips[$category] = $zips;
        } else {
            $this->zips[$category] = array_replace($this->zips[$category], $zips);
        }
    }
}
