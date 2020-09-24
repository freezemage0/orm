<?php
namespace Freezemage\Core\ORM\Query;

use Freezemage\Core\Exception\UnrecoverableException;
use Freezemage\Core\ORM\Condition\ConditionBuilder;

/**
 * Class ConditionalQuery
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
abstract class ConditionalQuery extends Query implements ConditionalQueryInterface
{
    protected $where;
    protected $conditionBuilder;

    public function setWhere(array $conditions): void
    {
        $conditionBuilder = new ConditionBuilder($this->manager->getProcessor());

        foreach ($conditions as $condition) {
            $conditionBuilder->addToChain($condition);
        }

        $this->where = $conditionBuilder->build();
    }

    public function __call($name, $arguments)
    {
        $isWhere = substr($name, 0, 5) === 'where';
        if (!$isWhere) {
            throw new \InvalidArgumentException("Undefined Condition: ${name}");
        }

        $operation = lcfirst(substr($name, 5));

        $operator = $this->createConditionBuilder()->getOperationName($operation);
        if ($operator === null) {
            throw new \InvalidArgumentException("Undefined operator: ${operator}.");
        }

        list($column, $value) = $arguments;
        $this->where($column, $value, $operator);
    }

    public function where($column, $value, string $operator = '=')
    {
        $this->createConditionBuilder()->addToChain(array($column, $value, $operator));
    }

    protected function createConditionBuilder(): ConditionBuilder
    {
        if ($this->conditionBuilder === null) {
            $this->conditionBuilder = new ConditionBuilder($this->manager->getProcessor());
        }

        return $this->conditionBuilder;
    }
}