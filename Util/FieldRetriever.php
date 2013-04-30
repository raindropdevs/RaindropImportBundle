<?php

namespace Raindrop\ImportBundle\Util;

use Doctrine\Common\Annotations\AnnotationReader;

use Raindrop\ImportBundle\Annotation\ImportExclude;
use Raindrop\ImportBundle\Util\CaseConverter;

/**
 * Retrieves the fields of a Doctrine entity that
 * are allowed to be imported
 */
class FieldRetriever
{
    protected $annotationReader;
    protected $caseConverter;

    /**
     * @param AnnotationReader $annotationReader The annotation reader service
     * @param CaseConverter    $caseConverter    The caseConverter service
     */
    public function __construct($annotationReader, CaseConverter $caseConverter)
    {
        $this->annotationReader = $annotationReader;
        $this->caseConverter = $caseConverter;
    }

    /**
     * Get the entity field names
     *
     * @param string  $class     The class name
     * @param string  $format    The desired field case format
     * @param boolean $copyToKey Copy the field values to their respective key
     *
     * @return array $fields
     */
    public function getFields($class, $format = 'title', $copyToKey = false)
    {
        $reflectionClass = new \ReflectionClass($class);
        $properties = $reflectionClass->getProperties();

        $fields = array();
        foreach ($properties as $property) {
            $addField = true;
            foreach ($this->annotationReader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof ImportExclude) {
                    $addField = false;
                }
            }

            if ($addField) {
                $fields[] = $this->caseConverter->convert($property->getName(), $format);
            }
        }

        if ($copyToKey) {
            $fields = array_combine($fields, $fields);
        }

        return $fields;
    }
}
