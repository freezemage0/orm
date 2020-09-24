<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 24.09.2020
 * Time: 22:08
 */

namespace Freezemage\ORM\Persistence;


interface ConnectionInterface
{
    public function connect(): void;

    public function close(): void;

    public function query(string $query): ResultInterface;

    public function quote(string $identifier): string;

    public function prepare(string $value): string;

    public function exists(string $name);

    public function getDbType(): string;
}