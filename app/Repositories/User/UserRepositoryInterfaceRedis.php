<?php
namespace App\Repositories\User;

interface UserRepositoryInterfaceRedis
{
  public function fetchAllByConditionRedis(array $condition, $orderBy = null);
}