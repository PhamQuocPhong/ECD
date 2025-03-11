<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use DB;

class LogoutController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function logout(Request $request)
    {
        DB::beginTransaction();
        $requestData = collect();
        $requestData->token = $request->bearerToken();
        $requestData->currentUser = JWTAuth::user();

        try {
            $this->service->handleLogout($requestData);
            $dataResponse = [];
            $message = null;
            $statusCode = 200;
            DB::commit();
            return showResponse($dataResponse, $message, $statusCode);
        } catch (Exception $e) {
            DB::rollback();
            throw $exception;
        }
    }

}
