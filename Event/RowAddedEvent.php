<?php

namespace Raindrop\ImportBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Row added event
 */
class RowAddedEvent extends Event
{
    protected $object;
    protected $row;
    protected $config;

    /**
     * @param DoctrineObject $object The new object being persisted
     * @param array          $row    The row being imported
     * @param array          $config The available configuration infos
     */
    public function __construct($object, array $row, array $config)
    {
        $this->object = $object;
        $this->row = $row;
        $this->config = $config;
    }

    /**
     * Get the doctrine object
     *
     * @return DoctrienObject
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Get field row
     *
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Get configuration infos
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
