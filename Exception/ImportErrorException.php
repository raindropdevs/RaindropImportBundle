<?php

namespace Raindrop\ImportBundle\Exception;

/**
 * Thrown when a row cannot be imported.
 *
 * @api
 */
class ImportErrorException extends \ErrorException implements ExceptionInterface
{
}
