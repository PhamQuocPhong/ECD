<?php
namespace App\Repositories\User;

interface UserRepositoryInterfaceElastic
{
  public function fetchAllByConditionElastic(array $condition, $orderBy = null);
}