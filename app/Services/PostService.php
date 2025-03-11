<?php
namespace App\Services;

use App\Repositories\Post\PostRepositoryInterfaceRedis;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class PostService
{
    public $postRepo;
    private $userRepo;

    public function __construct(PostRepositoryInterface $postRepo, UserRepositoryInterface $userRepo)
    {
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
    }

    public function fetchAllByCondition($params)
    {
    
        $posts =  Cache::remember('post_all', 60, function() use($params) {
            return $this->postRepo->fetchAllByCondition($params);
        });

        return $posts; 
    }

    public function store($requestData)
    {
        $userId = data_get($requestData, 'userId');
        $currentUser = $requestData->currentUser;
        $data = [
            'title' => data_get($requestData, 'title'),
            'description' => data_get($requestData, 'description'),
            'user_id' => $currentUser->id,
            'published_at' => Carbon::now(),
            'User' => $currentUser
        ];

        $post = $this->postRepo->store($data);
        $post->addToIndex();
        return $post; 
    }
}
