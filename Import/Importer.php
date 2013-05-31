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
    protected $reader;
    protected $dispatcher;
    protected $caseConverter;
    protected $objectManager;
    protected $adapter;
    protected $batchSize = 20;
    protected $importCount = 0;
    protected $config;
    protected $results = array();

    /**
     * @param CsvReader       $reader        The csv reader
     * @param Dispatcher      $dispatcher    The event dispatcher
     * @param CaseConverter   $caseConverter The case Converter
     * @param ObjectManager   $objectManager The Doctrine Object Manager
     * @param ImportInterface $adapter       The adapter used to import a row
     * @param int             $batchSize     The batch size before flushing & clearing the om
     */
    public function __construct(Reader $reader, EventDispatcherInterface $dispatcher, CaseConverter $caseConverter, ObjectManager $objectManager, ImportInterface $adapter, $batchSize, $eventLabel)
    {
        $this->reader = $reader;
        $this->dispatcher = $dispatcher;
        $this->caseConverter = $caseConverter;
        $this->objectManager = $objectManager;
        $this->adapter = $adapter;
        $this->batchSize = $batchSize;
        $this->eventLabel = $eventLabel;
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

        // add file headers to import configuration
        $config['headers'] = $this->headers;

        // add file name to import configuration
        $config['fileName'] = $this->reader->getFileName();
        $this->config = $config;
    }

    /**
    * Get the csv's header row
    *
    * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
    * Get the csv's next row
    *
    * @return array
    */
    public function getRow()
    {
        return $this->reader->getRow();
    }

    /**
     * Import the csv and persist to database
     *
     * @return array adapter results array
     */
    public function import()
    {
        while ($row = $this->getRow()) {
            $this->addRow($row, true);
            $this->objectManager->clear();
            $this->importCount++;
            $this->memUsage();
        }

        // one last flush to make sure no persisted objects get left behind
        $this->objectManager->flush();

        return $this->results;
    }

    /**
     * Add Csv row to db
     *
     * @param array   $row      An array of data
     * @param boolean $andFlush Flush the ObjectManager
     */
    private function addRow($row)
    {
        $this->results[] = $this->adapter->import($row, $this->config);

        $entity = $this->adapter->getObject();

        if (null !== $entity) {
            $this->objectManager->persist($entity);
            $this->objectManager->flush();

            $this->dispatcher->dispatch($this->eventLabel, new RowAddedEvent($entity, $row, $this->config));

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

    protected function memUsage()
    {
        echo $this->formatSize(memory_get_usage(true)) . "\n";
    }

    protected function formatSize($bytes)
    {
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );

                return( round( $bytes, 2 ) . " " . $types[$i] );
    }
}
