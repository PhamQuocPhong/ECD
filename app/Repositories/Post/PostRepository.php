<?php
namespace App\Repositories\Post;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Carbon;
use App\Models\Post;

class PostRepository extends BaseRepository 
    implements PostRepositoryInterface
{

    const POST_LIMIT = 50;
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * Get 5 posts hot in a month the last
     * @return mixed
     */


    public function fetchAllByCondition(array $params, $orderBy = null)
    {
        // $query = ['match' => ['email' => 'grimes.adaline@example.com']];
        // $sourceFields = ['id', 'name', 'email'];

        // $response = $this->model->searchByQuery($query, null, $sourceFields, self::USER_LIMIT);
        $model = $this->model->with("user");
        $titleRequest = data_get($params, "title");
        if($titleRequest)
        {
            $model = $model->where("title", "LIKE", "%" . $titleRequest . "%");
        }
    
        return $model->get();
    }

}