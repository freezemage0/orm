<?php


namespace Freezemage\Core\ORM\Query;


/**
 * Interface ConditionalQueryInterface
 *
 * @method whereIn(string $column, $value);
 * @method whereLess(string $column, $value);
 * @method whereNotLess(string $column, $value);
 * @method whereMore(string $column, $value);
 * @method whereNotMore(string $column, $value);
 * @method whereNotEqual(string $column, $value);
 * @method whereEqual(string $column, $value);
 *
 * @package Freezemage\Core\ORM\Query
 */
interface ConditionalQueryInterface extends QueryInterface
{
    public function setWhere(array $conditions): void;
}