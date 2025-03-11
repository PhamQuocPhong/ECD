<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;


class UserController extends Controller
{
    //
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function fetchAll(Request $request)
    {
        DB::beginTransaction();
        $params = $request->all();
        try {
            $users = $this->service->fetchAll($params);
            DB::commit();
            return response()->json(["data" => $users]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }

    public function batchEmailNotifications(Request $request)
    {

        DB::beginTransaction();
        $params = $request->all();
        try {
            $users = $this->service->fetchAll($params);
            $this->service->handleBatchMailNotifications($users);

            DB::commit();
            return response()->json(["data" => $users]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }

    public function bulkCretePosts(Request $request)
    {

        DB::beginTransaction();
        $params = $request->all();
        
        try {
            $users = $this->service->fetchAllByCondition($params);            
            $this->service->handleBulkCretePosts($users);
            $message = null;
            $statusCode = 200;
            DB::commit();
            return showResponse($users, $message, $statusCode);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }
}
