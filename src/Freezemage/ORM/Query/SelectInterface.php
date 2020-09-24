<?php


namespace Freezemage\Core\ORM\Query;


interface SelectInterface extends ConditionalQueryInterface
{
    public function setJoins(array $relations): void;

    public function setSelect(array $columns): void;

    public function setLimit(int $limit): void;

    public function setOffset(int $offset): void;

    public function setOrder(string $column, string $direction): void;
}