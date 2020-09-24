<?php
namespace Freezemage\Core\ORM\Field;

class IntegerField extends Field
{
    protected const DEFAULT_LENGTH = 11;

    protected $length;

    public function getType()
    {
        return 'INTEGER';
    }

    public function getColumnDescription()
    {
        if ($this->getLength() !== IntegerField::DEFAULT_LENGTH) {
            return $this->getType() . '(' . $this->getLength() . ')';
        }
        return $this->getType();
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length ?? static::DEFAULT_LENGTH;
    }

    /**
     * @param int $length
     * @return IntegerField
     */
    public function setLength(int $length)
    {
        $this->length = $length;
        return $this;
    }
}