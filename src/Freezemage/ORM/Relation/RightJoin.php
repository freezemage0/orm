<?php


namespace Freezemage\Core\ORM\Relation;


class RightJoin extends Join
{
    protected function getRelationTemplate()
    {
        return 'RIGHT JOIN %s ON %s = %s';
    }
}