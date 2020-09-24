<?php
namespace Freezemage\Core\ORM\Mysql;

use Freezemage\Core\ORM\Query\ConditionalQuery;
use Freezemage\Core\ORM\Query\UpdateInterface;

class Update extends ConditionalQuery implements UpdateInterface
{
    protected $values;

    public function setData(array $data): void
    {
        foreach ($data as $column => $value) {
            $item = array(
                $this->mapper->getProcessor()->quote($column),
                '=',
                $this->mapper->getProcessor()->prepare($value)
            );

            $this->values[] = implode(' ', $item);
        }
    }

    protected function buildUpdate()
    {
        return 'UPDATE ' . $this->mapper->getProcessor()->quote($this->mapper->getTableName());
    }

    protected function buildSet()
    {
        if ($this->values === null) {
            return null;
        }

        return 'SET ' . implode(', ', $this->values);
    }

    protected function buildWhere()
    {
        if ($this->where === null) {
            return null;
        }

        return 'WHERE ' . $this->where;
    }

    public function build()
    {
        return $this
            ->attach($this->buildUpdate())
            ->attach($this->buildSet())
            ->attach($this->buildWhere())
            ->compile();
    }
}