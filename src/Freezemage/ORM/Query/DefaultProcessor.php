<?php
namespace Freezemage\Core\ORM\Query;

use Freezemage\ORM\Persistence\ConnectionInterface;

class DefaultProcessor implements IProcessor
{
    protected $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function quote($identifier)
    {
        return $this->connection->quote($identifier);
    }

    public function prepare($value)
    {
        return $this->connection->prepare($value);
    }
}