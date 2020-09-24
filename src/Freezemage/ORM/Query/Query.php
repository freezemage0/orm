<?php
namespace Freezemage\Core\ORM\Query;

use Freezemage\Core\ORM\EntityManager;

abstract class Query implements QueryInterface
{
    protected $manager;
    protected $parts;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->parts = array();
    }

    public function attach(?string $part)
    {
        $this->parts[] = $part;
        return $this;
    }

    public function compile()
    {
        return implode(' ', array_filter($this->parts));
    }

    abstract public function build();
}