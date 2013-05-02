<?php

namespace Raindrop\ImportBundle\Zip;

use Raindrop\ImportBundle\Zip\Zip;
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
     * @param array $zips An array of Zip objects
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
    public function all($index = null)
    {
        if (null === $index) {
            return $this->zips;
        }

        return isset($this->zips[$index]) ? $this->zips[$index] : array();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function get($index)
    {
        if (isset($this->zips[$index])) {
            return $this->zips[$index];
        }

        return $index;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function replace($zip, $index)
    {
        $this->zips[$index] = array();

        $this->add($zip, $index);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function add($zip, $index)
    {
        if (!isset($this->zips[$index])) {
            $this->zips[$index] = $zip;
        } else {
            $this->zips[$index] = $zip;
        }
    }
}
