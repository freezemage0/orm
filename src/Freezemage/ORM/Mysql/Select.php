<?php
namespace Freezemage\Core\ORM\Mysql;

use Freezemage\Core\ORM\Field\Field;
use Freezemage\Core\ORM\Query\ConditionalQuery;
use Freezemage\Core\ORM\Query\SelectInterface;
use Freezemage\Core\ORM\Relation\Join;

class Select extends ConditionalQuery implements SelectInterface
{
    protected $select;
    protected $limit;
    protected $offset;
    protected $joins;
    protected $orderColumn;
    protected $orderDirection;

    public function setJoins(array $relations): void
    {
        foreach ($relations as $relation) {
            $this->joins[] = $relation;
        }
    }

    public function setSelect(array $columns): void
    {
        foreach ($columns as $column) {
            $this->select[] = $column;
        }
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    public function setOrder(string $column, string $direction): void
    {
        $this->orderColumn = $column;
        $this->orderDirection = $direction;
    }

    protected function getOrderColumn()
    {
        return $this->manager->getProcessor()->quote($this->orderColumn ?? $this->manager->getPrimaryField()->getName());
    }

    protected function getOrderDirection()
    {
        return $this->orderDirection ?? 'ASC';
    }

    protected function buildSelect()
    {
        $fields = $this->select;
        if (empty($fields)) {
            $fields = $this->manager->getFields();
        }

        $select = array();
        $processor = $this->manager->getProcessor();

        foreach ($fields as $item) {
            if ($item instanceof Field) {
                $field = $item;
            } else {
                $field = $this->manager->getField($item);
            }

            // Field is not found yet!
            if ($field === null) {
                foreach ($this->joins as $join) {
                    /** @var Join $join */
                    $referenceEntity = $join->getReferenceEntityManager();
                    $referenceField = $referenceEntity->getField($item);

                    if ($referenceField !== null) {
                        $field = $referenceField;
                        break;
                    }
                }
            }

            // Field found.
            if ($field !== null) {
                $alias = $field->getColumnAlias();
                $select[] = sprintf('%s AS %s', $field->getFullColumnName(), $alias);
            }
        }

        return 'SELECT ' . implode(', ', $select);
    }

    protected function buildFrom()
    {
        $tableName = $this->manager->getProcessor()->quote($this->manager->getTableName());
        return 'FROM ' . $tableName;
    }

    protected function buildJoin()
    {
        if ($this->joins === null) {
            return null;
        }

        $joins = array();
        foreach ($this->joins as $join) {
            /** @var Join $join */
            $joins[] = $join->build();
        }

        return implode(' ', $joins);
    }

    protected function buildWhere()
    {
        if (strlen($this->where) < 1) {
            return null;
        }

        return 'WHERE ' . $this->where;
    }

    protected function buildOrderBy()
    {
        $orderBy = array(
            'ORDER BY',
            $this->getOrderColumn(),
            $this->getOrderDirection()
        );

        return implode(' ', $orderBy);
    }

    protected function buildLimit()
    {
        if ($this->limit === null) {
            return null;
        }

        return 'LIMIT ' . $this->limit;
    }

    protected function buildOffset()
    {
        if ($this->limit === null || $this->offset === null) {
            return null;
        }

        return 'OFFSET ' . $this->offset;
    }

    public function build()
    {
        return $this
            ->attach($this->buildSelect())
            ->attach($this->buildFrom())
            ->attach($this->buildJoin())
            ->attach($this->buildWhere())
            ->attach($this->buildOrderBy())
            ->attach($this->buildLimit())
            ->attach($this->buildOffset())
            ->compile();
    }

}