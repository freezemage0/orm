<?php


namespace Freezemage\Core\ORM\Sqlite;


use Freezemage\ORM\Persistence\ConnectionInterface;
use Freezemage\Core\ORM\Query\BuilderFactoryInterface;

abstract class EntityManager extends \Freezemage\Core\ORM\EntityManager
{
    public function getBuilderFactory(): BuilderFactoryInterface
    {
        if ($this->builderFactory === null) {
            $this->builderFactory = new BuilderFactory($this);
        }
        return $this->builderFactory;
    }

    protected function getConnection(): ConnectionInterface
    {
        return $this->connectionPool->getConnectionByType('sqlite');
    }

}