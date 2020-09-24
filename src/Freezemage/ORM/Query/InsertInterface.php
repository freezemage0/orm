<?php


namespace Freezemage\Core\ORM\Query;


interface InsertInterface extends QueryInterface
{
    public function setData(array $data): void;
}