<?php
namespace App\Services;

use App\Repositories\User\UserRepositoryInterfaceRedis;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Redis;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
      $this->userRepo = $userRepo;
    }

    public function fetchProfile($currentUser)
    {
        $userId = $currentUser->id;
        return $this->userRepo->fetch($userId);
    }

}
