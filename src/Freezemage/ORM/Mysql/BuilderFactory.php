<?php


namespace Freezemage\Core\ORM\Mysql;


use Freezemage\Core\ORM\EntityMapper;
use Freezemage\Core\ORM\Query\BuilderFactoryInterface;
use Freezemage\Core\ORM\Query\CreateInterface;
use Freezemage\Core\ORM\Query\DeleteInterface;
use Freezemage\Core\ORM\Query\DropInterface;
use Freezemage\Core\ORM\Query\InsertInterface;
use Freezemage\Core\ORM\Query\SelectInterface;
use Freezemage\Core\ORM\Query\UpdateInterface;

class BuilderFactory implements BuilderFactoryInterface
{
    private $mapper;

    public function __construct(EntityMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getInsert(): InsertInterface
    {
        return new Insert($this->mapper);
    }

    public function getSelect(): SelectInterface
    {
        return new Select($this->mapper);
    }

    public function getUpdate(): UpdateInterface
    {
        return new Update($this->mapper);
    }

    public function getCreate(): CreateInterface
    {
        return new Create($this->mapper);
    }

    public function getDrop(): DropInterface
    {
        return new Drop($this->mapper);
    }

    public function getDelete(): DeleteInterface
    {
        return new Delete($this->mapper);
    }

}