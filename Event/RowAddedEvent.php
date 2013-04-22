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
    protected $fields;

    /**
     * @param DoctrineObject $object The new object being persisted
     * @param array          $row    The row being imported
     */
    public function __construct($object, array $row)
    {
        $this->object = $object;
        $this->row = $row;
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
}
