<?php

namespace Raindrop\ImportBundle\Import;

/**
 * ImportInterface
 */
interface ImportInterface
{
    /**
     * Import a row
     *
     * @param object $row
     * @param array  $config
     */
    public function import($row, $config);

    /**
     * Check validity
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Gets the object
     *
     * @return object
     */
    public function getObject();
}
