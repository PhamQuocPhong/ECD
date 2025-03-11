<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use JWTAuth;

class LoginController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        $requestData = (object) $request->only('email', 'password');
        $requestData->ip = $request->ip();
        try {
            $accessToken = $this->service->handleLogin($requestData);

            $dataResponse = ["accessToken" => $accessToken];
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
