<?php
namespace App\Services;

use App\Repositories\User\UserRepositoryInterfaceRedis;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Redis;

class UserService
{
    public $userRepoRedis;
    public $userRepo;

    public function __construct(UserRepositoryInterfaceRedis $userRepoRedis, UserRepositoryInterface $userRepo)
    {
      $this->userRepoRedis = $userRepoRedis;
      $this->userRepo = $userRepo;
    }

    public function fetchAll($params)
    {

      $users = Cache::remember('allUsers', 60, function() use ($params) {
        return $this->userRepo->fetchAllByCondition($params);
      });
      dd($users);

      return $users; 
    }

    public function fetch($id)
    {
      return $this->userRepoRedis->fetchByCondition1([], []);
    }
}