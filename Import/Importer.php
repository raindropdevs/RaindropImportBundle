<?php

namespace Raindrop\ImportBundle\Import;

use Raindrop\ImportBundle\Util\CaseConverter;
use Raindrop\ImportBundle\Event\RowAddedEvent;
use Raindrop\ImportBundle\Util\Reader;
use Raindrop\ImportBundle\Import\ImportInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
    protected $adapter;
    protected $config;

    /**
     * @param CsvReader       $reader        The csv reader
     * @param Dispatcher      $dispatcher    The event dispatcher
     * @param CaseConverter   $caseConverter The case Converter
     * @param ObjectManager   $objectManager The Doctrine Object Manager
     * @param ImportInterface $adapter       The adapter used to import a row
     * @param int             $batchSize     The batch size before flushing & clearing the om
     */
    public function __construct(Reader $reader, EventDispatcherInterface $dispatcher, CaseConverter $caseConverter, ObjectManager $objectManager, ImportInterface $adapter, $batchSize)
    {
        $this->reader = $reader;
        $this->dispatcher = $dispatcher;
        $this->caseConverter = $caseConverter;
        $this->objectManager = $objectManager;
        $this->adapter = $adapter;
        $this->batchSize = $batchSize;
    }

    /**
     * Import a file
     *
     * @param File   $file         The csv file
     * @param array  $config       The array with configuration infos
     * @param string $delimiter    The csv's delimiter
     * @param string $headerFormat The header case format
     *
     * @return boolean true if successful
     */
    public function init($file, array $config = array(), $delimiter = ',', $headerFormat = 'title')
    {
        $this->reader->open($file, $delimiter);
        $this->headers = $this->caseConverter->convert($this->reader->getHeaders(), $headerFormat);
        // add file name to import configuration
        $config['fileName'] = $this->reader->getFileName();
        $this->config = $config;
    }

    /**
     * Import the csv and persist to database
     *
     * @return true if successful
     */
    public function import()
    {
        while ($row = $this->reader->getRow()) {
            if (($this->importCount % $this->batchSize) == 0) {
                $this->addRow($row, true);
            } else {
                $this->addRow($row, false);
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
     * @param boolean $andFlush Flush the ObjectManager
     */
    private function addRow($row, $andFlush = true)
    {
        $this->adapter->import($row, $this->config);

        $entity = $this->adapter->getObject();

        if (null !== $entity) {
            $this->dispatcher->dispatch('raindrop_import.row_added', new RowAddedEvent($entity, $row, $this->config));
            $this->objectManager->persist($entity);
        }

        if ($andFlush) {
            $this->objectManager->flush();
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
