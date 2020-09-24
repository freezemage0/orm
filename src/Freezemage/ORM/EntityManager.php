<?php

namespace Freezemage\Core\ORM;

use Freezemage\ORM\Persistence\ConnectionInterface;
use Freezemage\ORM\Persistence\ConnectionPoolInterface;
use Freezemage\Core\ORM\Field\Field;
use Freezemage\Core\ORM\Query\DefaultProcessor;
use Freezemage\Core\ORM\Query\BuilderFactoryInterface;
use Freezemage\Core\ORM\Query\QueryInterface;

abstract class EntityManager
{
    protected $connectionPool;
    protected $processor;
    protected $builderFactory;
    protected $lastQueryString;
    protected $transactionManager;
    protected $fields;

    public function __construct(ConnectionPoolInterface $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    public function create()
    {
        $query = $this->getBuilderFactory()->getCreate();

        return $this->execute($query);
    }

    public function drop()
    {
        $query = $this->getBuilderFactory()->getDrop();

        return $this->execute($query);
    }

    public function execute(QueryInterface $query)
    {
        $queryString = $query->build();
        $this->lastQueryString = $queryString;

        return $this->getConnection()->query($queryString);
    }

    public function getProcessor()
    {
        if ($this->processor === null) {
            $this->processor = new DefaultProcessor($this->getConnection());
        }

        return $this->processor;
    }

    public function exists()
    {
        return $this->getConnection()->exists($this->getTableName());
    }
    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        if ($this->fields === null) {
            /** @var Field $field */
            foreach ($this->getMap() as $field) {
                $field->setProcessor($this->getProcessor());
                $field->setReferenceAlias($this->getReferenceAlias());
                $this->fields[] = $field;
            }
        }
        return $this->fields;
    }

    public function getPrimaryField(): ?Field
    {
        foreach ($this->getFields() as $field) {
            if ($field->isPrimary()) {
                return $field;
            }
        }

        return null;
    }

    public function getField(string $name): ?Field
    {
        foreach ($this->getFields() as $field) {
            if ($field->getName() === $name) {
                return $field;
            }
        }

        return null;
    }

    public function getReferenceAlias()
    {
        return strtoupper($this->getTableName());
    }

    abstract public function getBuilderFactory(): BuilderFactoryInterface;

    abstract public function getTableName(): string;

    abstract protected function getMap(): array;

    abstract protected function getConnection(): ConnectionInterface;
}