<?php

namespace Raindrop\ImportBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Row error event
 */
class RowErrorEvent extends Event
{
    protected $object;
    protected $row;
    protected $config;
    protected $error;

    /**
     * @param DoctrineObject $object The new object being persisted
     * @param array          $row    The row being imported
     * @param array          $config The available configuration infos
     * @param string         $error  The error message
     */
    public function __construct($object, array $row, array $config, $error)
    {
        $this->object = $object;
        $this->row = $row;
        $this->config = $config;
        $this->error = $error;
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

    /**
     * Get error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
