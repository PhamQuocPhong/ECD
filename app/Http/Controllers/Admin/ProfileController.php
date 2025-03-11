<?php

namespace App\Http\Controllers\Admin;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;
use Auth;


class ProfileController extends Controller
{
    //
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function me(Request $request)
    {
       
        DB::beginTransaction();
        try {
            $currentUser = Auth::guard('admin')->user();
            DB::commit();
            return response()->json(["data" => $currentUser]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return response()->json(["error" => "Internal Server Error"], 500);
        }
    }
}
