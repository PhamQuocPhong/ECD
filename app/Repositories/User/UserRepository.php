<?php
namespace App\Repositories\User;
use App\Repositories\User\UserRepositoryInterfaceRedis;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterfaceRedis, UserRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get 5 posts hot in a month the last
     * @return mixed
     */


    public function fetchByCondition1(array $condition, $orderBy = null)
    {
        dd(1);
    }
}