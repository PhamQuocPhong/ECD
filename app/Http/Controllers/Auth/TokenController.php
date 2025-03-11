<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use JWTAuth;
use DB;

class TokenController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function refreshToken(Request $request)
    {
        DB::beginTransaction();

        try {
            $accessToken = $this->service->refreshToken();
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
