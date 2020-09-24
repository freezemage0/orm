<?php


namespace Freezemage\Core\ORM\Relation;


class LeftJoin extends Join
{
    protected function getRelationTemplate()
    {
        return 'LEFT JOIN %s ON %s = %s';
    }

}