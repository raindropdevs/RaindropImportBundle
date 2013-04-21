<?php

namespace Raindrop\ImportBundle\Import;

/**
 * BaseAdapter
 */
abstract class BaseAdapter implements ImportInterface
{
    /**
     * @var object
     */
    protected $entity;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var Doctrine\ORM\EntityRepository
     */
    protected $entityRepository;

    /**
     * @return boolean
     */
    public function isValid()
    {
        return true;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->entity;
    }

    /**
     * @param array $params
     *
     * @return object
     */
    public function find(array $params)
    {
        $object = $this->entityRepository->findOneBy($params);

        if (is_null($object)) {
            $object = new $this->entityName;
        }

        return $object;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @param Doctrine\ORM\EntityRepository $entityRepository
     */
    public function setEntityRepository(\Doctrine\ORM\EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }
}
