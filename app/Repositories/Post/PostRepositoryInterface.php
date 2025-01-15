<?php
namespace App\Repositories\Post;

interface PostRepositoryInterface
{
  public function fetchAllByCondition(array $condition, $orderBy = null);
}