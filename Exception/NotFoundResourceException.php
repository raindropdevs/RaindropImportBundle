<?php

namespace Raindrop\ImportBundle\Exception;

/**
 * Thrown when a resource does not exist.
 *
 * @api
 */
class NotFoundResourceException extends \InvalidArgumentException implements ExceptionInterface
{
}
