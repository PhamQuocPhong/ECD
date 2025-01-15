<?php
namespace App\Repositories\AccessToken;
use App\Repositories\AccessToken\AccessTokenRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\AccessToken;

class AccessTokenRepository extends BaseRepository implements AccessTokenRepositoryInterface
{
    public function __construct(AccessToken $model)
    {
        parent::__construct($model);
    }
}