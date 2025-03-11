<?php
namespace App\Services\Admin;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Jobs\BulkCreatePost;
use App\Models\User;
use Faker\Factory as Faker;
class UserService
{
    public $userRepo;

    public function __construct( UserRepositoryInterface $userRepo)
    {
      $this->userRepo = $userRepo;
    }

    public function fetchAllByCondition($params)
    {
        return  $this->userRepo->fetchAllByCondition($params);
    }

    public function handleBatchMailNotifications($users)
    {
        dd($users);
    }

    public function handleBulkCretePosts($users)
    {
        foreach($users as $key => $user)
        {
          BulkCreatePost::dispatch($user)->delay(1);
        }
    }
}
