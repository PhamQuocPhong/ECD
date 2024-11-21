<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
  public function fetchAllByCondition(array $condition, $orderBy = null);
}