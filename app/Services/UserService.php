<?php
namespace App\Services;

use App\Repositories\User\UserRepositoryInterfaceRedis;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Redis;
use Illuminate\Support\Facades\Hash;

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
      $users = $this->userRepo->fetchAllByConditionElastic($params);
      // $users = Cache::remember('allUsers', 60, function() use ($params) {
        
      // });
      // dd($users);

      return $users; 
    }

    public function fetch($id)
    {
      return $this->userRepoRedis->fetchByCondition1([], []);
    }

    public function store($request)
    {
      $data = [
        "name" => data_get($request->name),
        "email" => data_get($request->email),
        "password" =>  Hash::make($request->password)
      ];
      $user = $this->userRepo->store($data);
      return $user; 
    }
}
