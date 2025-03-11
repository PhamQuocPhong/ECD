<?php

namespace App\Http\Controllers;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use Exception;
use DB;


class ProfileController extends Controller
{
    //
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function me()
    {
        $currentUser = JWTAuth::user();
       
        DB::beginTransaction();
        try {
            $profile = $this->service->fetchProfile($currentUser);
            DB::commit();
            return response()->json(["data" => $profile]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }
}
