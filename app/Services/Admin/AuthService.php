<?php
namespace App\Services\Admin;

use App\Repositories\User\UserRepositoryInterface;

use Illuminate\Support\Facades\Cache;
use App\Exceptions\LoginException;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public $userRepo;

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
        $credentials = ["email" => $requestData->email, "password" => $requestData->password];
        $condition = [
            "email" => $credentials["email"]        
        ];
        $user = $this->userRepo->fetchByCondition($condition) ;
        $http = new \GuzzleHttp\Client;
        $response = $http->post('http://ecd:80/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_CLIENT_ID'),    // Replace with your client ID
                'client_secret' => env('PASSPORT_CLIENT_SECRET'), // Replace with your client secret
                'username' => $credentials['email'],
                'password' => $credentials['password'],
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
	}
}
