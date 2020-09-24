<?php
namespace Freezemage\Core\ORM\Sqlite;

use Freezemage\Core\ORM\Query\InsertInterface;
use Freezemage\Core\ORM\Query\Query;

class Insert extends Query implements InsertInterface
{
    protected $columns;
    protected $values;

    public function setData(array $data): void
    {
        $processor = $this->mapper->getProcessor();

        foreach ($data as $column => $value) {
            $this->columns[] = $processor->quote($column);
            $this->values[] = $processor->prepare($value);
        }
    }

    protected function buildInsert()
    {
        return 'INSERT INTO ' . $this->mapper->getProcessor()->quote($this->mapper->getTableName());
    }

    protected function buildColumns()
    {
        if ($this->columns === null) {
            return null;
        }

        return '(' . implode(', ', $this->columns) . ')';
    }

    protected function buildValues()
    {
        if ($this->values === null) {
            return null;
        }

        return 'VALUES (' . implode(', ', $this->values) . ')';
    }

    public function build()
    {
        return $this
            ->attach($this->buildInsert())
            ->attach($this->buildColumns())
            ->attach($this->buildValues())
            ->compile();
    }
}