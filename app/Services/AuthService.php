<?php
namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\AccessToken\AccessTokenRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\LoginException;
use App\Exceptions\TokenException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public $userRepo;
    public $accessTokenRepo;
	const TOKEN_TYPE = "Bearer";

    public function __construct(
        UserRepositoryInterface $userRepo,
        AccessTokenRepositoryInterface $accessTokenRepo
    )
	{
      	$this->userRepo = $userRepo;
        $this->accessTokenRepo = $accessTokenRepo;
    }

	/**
     *
     * @return string
     */
	public function handleLogin($requestData)
	{
        $credentials = ["email" => $requestData->email, "password" => $requestData->password];
		$accessToken = JWTAuth::attempt($credentials);
        if(!$accessToken)
        {
        	throw new LoginException(__('auth.invalid_email_or_password'), Response::HTTP_UNAUTHORIZED);
        }
        return $accessToken;
	}

	/**
     *
     * @return Model AccessToken
     */
	public function storeAccessToken($requestData)
	{
		$now = Carbon::now();
		try {
			$data = [
				'ip' => $requestData->ip,
				'user_id' => $requestData->userId,
				'token_type' => self::TOKEN_TYPE,
				'token' => $requestData->token,
				'expires_in' => JWTAuth::factory()->getTTL(),
				'expired_at' => $now->addMinutes(env('JWT_TTL')),
			];
			return $this->accessTokenRepo->store($data);
		} 
		catch(Exception $e)
		{
			throw new TokenException(__('auth.store_access_token_failed'));
		}
	}

	/**
     *
     * @return Model AccessToken
     */
	public function refreshToken($requestData)
	{
		$token = $requestData->token;
		$now = Carbon::now();
		$findToken = $this->accessTokenRepo->fetchByCondition(["token" => $token]);
		if(!$findToken){
			throw new TokenException(__('auth.token_invalid'), Response::HTTP_UNAUTHORIZED);
		}
		try{
			$newToken = JWTAuth::refresh($token);
			$findToken = $this->accessTokenRepo->update($findToken->id, [
				'expires_in' => JWTAuth::factory()->getTTL(),
				'expired_at' => $now->addMinutes(env('JWT_TTL')),
				'token' => $newToken,
			]);
		}catch(TokenInvalidException $e){
			throw new TokenException(__('auth.token_invalid'), Response::HTTP_UNAUTHORIZED);
		}
		return $findToken;
	} 

	/**
     *
     * @return Boolean
     */
	public function handleLogout($requestData)
	{
		$userId = $requestData->currentUser->id;
		$token = $requestData->token;
		$findAccessToken = $this->accessTokenRepo->fetchByCondition(["token" => $token, "user_id" => $userId]);
		if(!$findAccessToken){
			throw new TokenException(__('auth.token_invalid'));
		}

		try{
			JWTAuth::parseToken()->invalidate();
		}catch(TokenInvalidException $e){
			throw new TokenException(__('auth.token_invalid'));
		}
		return true;
	}
}
