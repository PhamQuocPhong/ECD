<?php

namespace App\Http\Controllers;
use App\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use JWTAuth;
use DB;


class PostController extends Controller
{
    //
    private $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function fetchAll(Request $request)
    {
        DB::beginTransaction();
        $params = $request->all();
        try {
            $posts = $this->service->fetchAll($params);
            DB::commit();
            return response()->json(["data" => $posts]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }

    public function fetch($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->service->fetch($id);
            DB::commit();
            return response()->json(["data" => $post]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }

    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        $requestData =  (object) $request->only('title', 'description');
        $requestData->currentUser = JWTAuth::user();

        try {
            $post = $this->service->store($requestData);
            DB::commit();
            return response()->json(["data" => $post]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }
}
