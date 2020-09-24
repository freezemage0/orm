<?php
namespace Freezemage\Core\ORM\Field;

use Freezemage\Core\ORM\EntityMapper;
use Freezemage\Core\ORM\Query\IProcessor;

abstract class Field
{
    protected $name;
    protected $primary;
    protected $required;
    protected $autoincrement;
    protected $referenceAlias;
    protected $processor;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setPrimary(bool $primary)
    {
        $this->primary = $primary;
        return $this;
    }

    public function setRequired(bool $required)
    {
        $this->required = $required;
        return $this;
    }

    public function setAutoincrement(bool $autoincrement)
    {
        $this->autoincrement = $autoincrement;
        return $this;
    }

    public function setReferenceAlias(string $referenceAlias)
    {
        $this->referenceAlias = $referenceAlias;
    }

    public function isPrimary()
    {
        return $this->primary ?? false;
    }

    public function isRequired()
    {
        return $this->required ?? false;
    }

    public function isAutoincrement()
    {
        return $this->autoincrement ?? false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullColumnName()
    {
        return $this->processor->quote($this->mapper->getTableName()) . '.' . $this->processor->quote($this->getName());
    }

    public function getColumnAlias()
    {
        $alias = $this->referenceAlias . '_' . $this->getName();
        return $this->processor->quote($alias);
    }

    /**
     * @return string
     */
    abstract public function getType();

    abstract public function getColumnDescription();

    public function setProcessor(IProcessor $processor)
    {
        $this->processor = $processor;
    }
}