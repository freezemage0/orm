<?php

namespace Freezemage\Core\ORM\Condition;

use Freezemage\Core\Exception\UnrecoverableException;
use Freezemage\Core\ORM\Buildable;
use Freezemage\Core\ORM\Query\IProcessor;

class ConditionBuilder implements Buildable
{
    protected $processor;
    protected $chain;
    protected $lastChainElement;
    protected $operators;

    public function __construct(IProcessor $processor)
    {
        $this->processor = $processor;
        $this->chain = array();
    }

    public function addToChain($item): ConditionBuilder
    {
        if (is_array($item)) {
            $this->lastChainElement = $this->addExpressionToChain(...$item);
            return $this;
        }

        if (Logic::isLogical($item)) {
            $this->lastChainElement = $this->addLogicToChain($item);
            return $this;
        }

        throw new \InvalidArgumentException('Failed to add item to chain: invalid item type.');
    }

    public function addExpressionToChain($column, $value, $operator = '=')
    {
        $column = $this->processor->quote($column);
        if (is_array($value)) {
            foreach ($value as &$item) {
                $item = $this->processor->prepare($item);
            }
            $operator = 'in';

            $value = '(' . implode(', ', $value) . ')';
        } else {
            $value = $this->processor->prepare($value);
        }

        $expression = new Expression($column, $value, $operator);

        if ($this->lastChainElement instanceof Expression) {
            $this->chain[] = new Logic();
        }

        return $this->chain[] = $expression;
    }

    public function addLogicToChain($operator)
    {
        $logic = new Logic($operator);

        if ($this->lastChainElement instanceof Logic) {
            throw new \LogicException('Cannot add two consecutive logic elements to chain');
        }

        return $this->chain[] = $logic;
    }

    public function build()
    {
        $chain = array();

        foreach ($this->chain as $element) {
            $chain[] = $element->build();
        }

        return implode(' ', $chain);
    }

    public function getOperationName(string $operator): ?string
    {
        if ($this->operators === null) {
            $this->operators = array(
                '<' => 'less',
                '>' => 'more',
                '<>' => 'notEqual',
                '=' => 'equal',
                '!=' => 'notEqual',
                '<=' => 'notMore',
                '>=' => 'notLess',
                'in' => 'in'
            );
        }

        $operation = array_search($operator, $this->operators);

        if ($operation === false) {
            return null;
        }

        return $operation;
    }
}