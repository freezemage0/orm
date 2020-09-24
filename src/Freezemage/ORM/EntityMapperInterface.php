<?php


namespace Freezemage\Core\ORM;


use Freezemage\Core\ORM\Field\Field;

interface EntityMapperInterface
{
    /**
     * @return Field[]
     */
    public function getFields(): array;

    public function getField(string $name): ?Field;

    public function getPrimaryField(): ?Field;

    public function createEntity(array $data): EntityInterface;

    /**
     * @return Field[]
     */
    public function getMap(): array;

    public function getTableName(): string;

    public function validateEntity(EntityInterface $entity): bool;
}