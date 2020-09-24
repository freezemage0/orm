<?php
namespace Freezemage\Core\ORM\Query;

use Freezemage\Core\Connection\ConnectionInterface;

interface IProcessor
{
    /**
     * @see ConnectionInterface::quote()
     *
     * @param string $identifier
     * @return string
     */
    public function quote($identifier);

    /**
     * @see ConnectionInterface::prepare()
     *
     * @param string|int $value
     * @return string|int
     */
    public function prepare($value);
}