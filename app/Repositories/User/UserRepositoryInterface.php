<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
  public function fetchByCondition1(array $condition, $orderBy = null);
}