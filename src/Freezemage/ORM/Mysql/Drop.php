<?php
namespace Freezemage\Core\ORM\Mysql;

use Freezemage\Core\ORM\Query\DropInterface;
use Freezemage\Core\ORM\Query\Query;

class Drop extends Query implements DropInterface
{
    public function build()
    {
        return 'DROP TABLE ' . $this->mapper->getProcessor()->quote($this->mapper->getTableName());
    }
}