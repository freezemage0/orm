<?php


namespace Freezemage\Core\ORM\Relation;


class InnerJoin extends Join
{
    protected function getRelationTemplate()
    {
        return 'INNER JOIN %s ON %s = %s';
    }
}