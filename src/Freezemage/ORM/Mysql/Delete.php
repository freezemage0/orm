<?php
namespace Freezemage\Core\ORM\Mysql;

use Freezemage\Core\ORM\Query\ConditionalQuery;
use Freezemage\Core\ORM\Query\DeleteInterface;

class Delete extends ConditionalQuery implements DeleteInterface
{
    protected function buildDelete()
    {
        return 'DELETE FROM ' . $this->mapper->getProcessor()->quote($this->mapper->getTableName());
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
            ->attach($this->buildDelete())
            ->attach($this->buildWhere())
            ->compile();
    }
}