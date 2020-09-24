<?php
namespace Freezemage\Core\ORM\Query;

use Freezemage\Core\ORM\EntityManager;

/**
 * Interface IBuilderFactory
 * Decouples the query building objects from EntityManager.
 * @see EntityManager
 *
 * @package Freezemage\Core\ORM\Query
 */
interface BuilderFactoryInterface
{
    /**
     * Returns INSERT query builder.
     *
     * @return InsertInterface
     */
    public function getInsert(): InsertInterface;

    /**
     * Returns SELECT query builder.
     *
     * @return SelectInterface
     */
    public function getSelect(): SelectInterface;

    /**
     * Returns UPDATE query builder.
     *
     * @return UpdateInterface
     */
    public function getUpdate(): UpdateInterface;

    /**
     * Returns CREATE TABLE query builder.
     *
     * @return CreateInterface
     */
    public function getCreate(): CreateInterface;

    /**
     * Returns DROP TABLE query builder.
     *
     * @return DropInterface
     */
    public function getDrop(): DropInterface;

    /**
     * Returns DELETE query builder.
     *
     * @return DeleteInterface
     */
    public function getDelete(): DeleteInterface;
}