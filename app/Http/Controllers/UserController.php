<?php

namespace App\Http\Controllers;
use App\Services\UserService;

use Illuminate\Http\Request;
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
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" . $e );
        }


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

    public function fetch($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->service->fetch($id);
            DB::commit();
            return response()->json(["data" => $user]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }
}
