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
        DB::beginTransaction();
        $form = $request->all();
        try {
            $users = $this->service->fetchAll($form);
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
