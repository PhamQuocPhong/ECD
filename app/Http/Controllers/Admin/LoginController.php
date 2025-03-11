<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;


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
        try {
            $dataResponse = $this->service->handleLogin($requestData);

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
