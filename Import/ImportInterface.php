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
     */
    public function import($row);

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
