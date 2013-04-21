<?php

namespace Raindrop\ImportBundle\Import;

use Raindrop\ImportBundle\Util\CaseConverter;
use Raindrop\ImportBundle\Event\RowAddedEvent;
use Raindrop\ImportBundle\Util\Reader;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Raindrop\ImportBundle\Import\ImportInterface;

/**
 * Import csv to doctrine entity/document
 */
class Importer
{
    protected $fields;
    protected $metadata;
    protected $reader;
    protected $batchSize = 20;
    protected $importCount = 0;
    protected $caseConverter;
    protected $objectManager;

    /**
     * @param CsvReader     $reader        The csv reader
     * @param Dispatcher    $dispatcher    The event dispatcher
     * @param CaseConverter $caseConverter The case Converter
     * @param ObjectManager $objectManager The Doctrine Object Manager
     * @param int           $batchSize     The batch size before flushing & clearing the om
     */
    public function __construct(Reader $reader, EventDispatcherInterface $dispatcher, CaseConverter $caseConverter, ObjectManager $objectManager, $batchSize, ImportInterface $adapter)
    {
        $this->reader = $reader;
        $this->dispatcher = $dispatcher;
        $this->caseConverter = $caseConverter;
        $this->objectManager = $objectManager;
        $this->batchSize = $batchSize;
        $this->adapter = $adapter;
    }

    /**
     * Import a file
     *
     * @param File   $file         The csv file
     * @param string $class        The class name of the entity
     * @param string $delimiter    The csv's delimiter
     * @param string $headerFormat The header case format
     *
     * @return boolean true if successful
     */
    public function init($file, $class, $delimiter = ',', $headerFormat = 'title')
    {
        $this->reader->open($file, $delimiter);
        $this->class = $class;
        $this->metadata = $this->objectManager->getClassMetadata($class);
        $this->headers = $this->caseConverter->convert($this->reader->getHeaders(), $headerFormat);
    }

    /**
     * Import the csv and persist to database
     *
     * @param array $fields The fields to persist
     *
     * @return true if successful
     */
    public function import($fields)
    {
        $fields = array_unique($this->caseConverter->toPascalCase($fields));

        while ($row = $this->reader->getRow()) {
            if (($this->importCount % $this->batchSize) == 0) {
                $this->addRow($row, $fields, true);
            } else {
                $this->addRow($row, $fields, false);
            }

            $this->importCount++;
        }

        // one last flush to make sure no persisted objects get left behind
        $this->objectManager->flush();

        return true;
    }

    /**
     * Add Csv row to db
     *
     * @param array   $row      An array of data
     * @param array   $fields   An array of the fields to import
     * @param boolean $andFlush Flush the ObjectManager
     */
    private function addRow($row, $fields, $andFlush = true)
    {
        $this->adapter->import($row);

        $entity = $this->adapter->getObject();

        $this->dispatcher->dispatch('raindrop_import.row_added', new RowAddedEvent($entity, $row, $fields));

        $this->objectManager->persist($entity);

        if ($andFlush) {
            $this->objectManager->flush();
            $this->objectManager->clear($this->class);
        }
    }

    /**
     * Get import count
     *
     * @return int
     */
    public function getImportCount()
    {
        return $this->importCount;
    }
}
