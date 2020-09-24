<?php


namespace Freezemage\Core\ORM\Relation;


use Freezemage\Core\ORM\EntityManager;
use Freezemage\Core\ORM\EntityMapper;

abstract class Join
{
    protected $entityManager;
    protected $referenceEntityManager;
    protected $relation;

    public function __construct(EntityManager $entityManager, EntityManager $referenceEntityManager, array $relation)
    {
        $this->entityManager = $entityManager;
        $this->referenceEntityManager = $referenceEntityManager;
        $this->relation = $relation;
    }

    public function getReferenceEntityManager(): EntityManager
    {
        return $this->referenceEntityManager;
    }

    public function getRelation()
    {
        return $this->relation;
    }

    public function build()
    {
        $destinationTable = $this->referenceEntityManager->getProcessor()->quote($this->referenceEntityManager->getTableName());

        list($sourceColumn, $destinationColumn) = $this->relation;
        $sourceField = $this->entityManager->getField($sourceColumn)->getFullColumnName();
        $destinationField = $this->referenceEntityManager->getField($destinationColumn)->getFullColumnName();

        return sprintf(
            $this->getRelationTemplate(),
            $destinationTable,
            $sourceField,
            $destinationField
        );
    }

    abstract protected function getRelationTemplate();
}