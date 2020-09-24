<?php


namespace Freezemage\Core\ORM\Sqlite;


use Freezemage\Core\ORM\EntityMapper;
use Freezemage\Core\ORM\Query\CreateInterface;
use Freezemage\Core\ORM\Query\DeleteInterface;
use Freezemage\Core\ORM\Query\BuilderFactoryInterface;
use Freezemage\Core\ORM\Query\DropInterface;
use Freezemage\Core\ORM\Query\InsertInterface;
use Freezemage\Core\ORM\Query\SelectInterface;
use Freezemage\Core\ORM\Query\UpdateInterface;

final class BuilderFactory implements BuilderFactoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getInsert(): InsertInterface
    {
        return new Insert($this->entityManager);
    }

    public function getSelect(): SelectInterface
    {
        return new Select($this->entityManager);
    }

    public function getUpdate(): UpdateInterface
    {
        return new Update($this->entityManager);
    }

    public function getCreate(): CreateInterface
    {
        return new Create($this->entityManager);
    }

    public function getDrop(): DropInterface
    {
        return new Drop($this->entityManager);
    }

    public function getDelete(): DeleteInterface
    {
        return new Delete($this->entityManager);
    }

}