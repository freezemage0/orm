<?php


namespace Freezemage\Core\ORM;


use Freezemage\Type\Collection;


interface EntityRepositoryInterface
{
    public function findBy(array $filter = array(), array $order = array(), int $limit = null, int $offset = null): Collection;

    public function persist(EntityInterface $entity): void;

    public function remove(EntityInterface $entity): void;

    public function count(): int;
}