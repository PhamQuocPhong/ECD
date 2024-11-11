<?php
namespace App\Repositories;
use Exception;

interface BaseRepositoryInterface
{
    public function fetchAll();

    public function fetchAllByCondition(array $condition, $orderBy = null);

    public function fetchByCondition(array $condition);

    public function fetchPaging(array $condition, $itemPerPage = 25, $oderBy = null);

    public function fetch($id);

    public function update($id, $data);

    public function updateByCondition(array $condition, $data);

    public function store($data);

    public function delete($id);

}