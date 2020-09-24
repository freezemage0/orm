<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 24.09.2020
 * Time: 22:12
 */

namespace Freezemage\ORM\Persistence;


interface ConnectionPoolInterface
{
    public function addConnection(ConnectionInterface $connection): void;

    public function getConnectionByType(string $type): ConnectionInterface;
}