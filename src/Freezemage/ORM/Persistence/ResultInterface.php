<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 24.09.2020
 * Time: 22:10
 */

namespace Freezemage\ORM\Persistence;


interface ResultInterface
{
    public function fetch();

    public function fetchAll();
}