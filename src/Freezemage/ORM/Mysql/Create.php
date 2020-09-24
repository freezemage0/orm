<?php
namespace Freezemage\Core\ORM\Mysql;

use Freezemage\Core\ORM\Query\CreateInterface;
use Freezemage\Core\ORM\Query\Query;

class Create extends Query implements CreateInterface
{
    public function build()
    {
        $columns = array();

        foreach ($this->mapper->getFields() as $field) {
            $column = array(
                $this->mapper->getProcessor()->quote($field->getName()),
                $field->getColumnDescription()
            );
            if ($field->isRequired()) {
                $column[] = 'NOT NULL';
            }
            if ($field->isPrimary()) {
                $column[] = 'PRIMARY KEY';
            }
            if ($field->isAutoincrement()) {
                $column[] = 'AUTO_INCREMENT';
            }

            $columns[] = implode(' ', $column);
        }

        $columns = implode(', ', $columns);

        return sprintf('CREATE TABLE %s (%s)', $this->mapper->getProcessor()->quote($this->mapper->getTableName()), $columns);
    }
}