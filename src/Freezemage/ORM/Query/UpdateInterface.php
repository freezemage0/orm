<?php


namespace Freezemage\Core\ORM\Query;


interface UpdateInterface extends ConditionalQueryInterface
{
    public function setData(array $data): void;
}