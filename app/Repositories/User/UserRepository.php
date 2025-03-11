<?php
namespace App\Repositories\User;
use App\Repositories\User\UserRepositoryInterfaceElastic;
use App\Repositories\User\UserRepositoryInterfaceRedis;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserRepository extends BaseRepository implements
    UserRepositoryInterfaceElastic, 
    UserRepositoryInterfaceRedis,
    UserRepositoryInterface
{

    const USER_LIMIT = 10000;
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get 5 posts hot in a month the last
     * @return mixed
     */


    public function fetchAllByConditionElastic(array $params, $orderBy = null)
    {
        $query = ['match' => $params];
        $sourceFields = ['id', 'name', 'email', 'email_verified_at', 'remember_token', 'created_at'];

        $users = $this->model->searchByQuery($query, null, $sourceFields, self::USER_LIMIT);
        return $users;
    }

    public function fetchAllByCondition(array $params, $orderBy = null)
    {
        $model = $this->model;
        $nameRequest = data_get($params, "name");
        if($nameRequest)
        {
            $model = $model->where("name", "LIKE", "%" . $nameRequest . "%");
        }
        return $model->get();
    }

    public function fetchAllByConditionRedis(array $params, $orderBy = null)
    {
        
    }
}