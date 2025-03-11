<?php
namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;

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
        UserRepositoryInterface $userRepo
    )
	{
      	$this->userRepo = $userRepo;

    }

	/**
     *
     * @return string
     */
	public function handleLogin($requestData)
	{
        $credentials = [
			"email" => $requestData->email, 
			"password" => $requestData->password
		];
		$accessToken = JWTAuth::attempt($credentials);
        if(!$accessToken)
        {
        	throw new LoginException(__('auth.invalid_email_or_password'), Response::HTTP_UNAUTHORIZED);
        }
        return $accessToken;
	}

	public function handleRegister($requestData)
	{	
		
	}

	/**
     *
     * @return string accessToken
     */
	public function refreshToken()
	{
		try{
			$newToken = JWTAuth::parseToken()->refresh();
		}catch(TokenInvalidException $e){
			throw new TokenException(__('auth.token_invalid'), Response::HTTP_UNAUTHORIZED);
		}
		return $newToken;
	} 

	/**
     *
     * @return Boolean
     */
	public function handleLogout($requestData)
	{
		$userId = $requestData->currentUser->id;
		$token = $requestData->token;
		if(!$token){
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
