<?php


namespace Freezemage\Core\ORM;


interface EntityInterface
{
    public function getId();

    public function toArray(): array;
}