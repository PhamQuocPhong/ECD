<?php
namespace App\Repositories\User;

interface UserRepositoryInterfaceRedis
{
  public function fetchByCondition(array $condition, $orderBy = null);
}