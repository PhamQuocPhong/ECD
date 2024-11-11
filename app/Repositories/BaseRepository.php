<?php

namespace App\Repositories;
use App\Repositories\BaseRepositoryInterface;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function fetchAll($orderBy = null)
    {
        if($orderBy)
        {
            $column = array_keys($orderBy)[0];
            $sort = $orderBy[$column];

            return $this->model->orderBy($column, $sort)->get();
        }
        return $this->model->get();
    }

    //  $orderBy: array; 
    public function fetchAllByCondition(array $condition, $orderBy = null)
    {
        if($orderBy)
        {
            $column = array_keys($orderBy)[0];
            $sort = $orderBy[$column];

            return $this->model->where($condition)->orderBy($column, $sort)->get();
        }
        return $this->model->where($condition)->get();
    }

    public function fetchByCondition(array $condition, $orderBy = null)
    {
        return $this->model->where($condition)->first();
    }

    public function fetchPaging(array $condition, $itemPerPage = 25, $orderBy = null)
    {

        if($orderBy)
        {
            $column = array_keys($orderBy)[0];
            $sort = $orderBy[$column];

            return $this->model->where($condition)->orderBy($column, $sort)->paginate($itemPerPage);
        }
        return $this->model->where($condition)->paginate($itemPerPage);
    }

    public function fetch($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        $response = $this->model->findOrFail($id);
        $response->fill($data);
        $response->save();
        return $response;
    }

    public function updateByCondition(array $condition, $data)
    {
        return $this->model->where($condition)->update($data);
    }


    public function updateOrCreate($condition, $data)
    {
        return $this->model->updateOrCreate($condition, $data);
    }

    public function store($data)
    {
        return  $this->model->create($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

}
