<?php

namespace App\Api;

use App\Controller\UserController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

/**
 * User Service Class
 * 
 * Handles user-related API endpoints including registration and authentication.
 * Extends ApiService for base API functionality.
 * 
 * @package App\Api
 * @extends ApiService
 */
class User extends ApiService
{
    /**
     * Constructor
     * 
     * Initializes the User service with request handling.
     * 
     * @param Request $request The HTTP request object
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }


    public function register(): JsonResponse
    {
        $this->validatePosts(['email'=>'email' , 'password'=>'string']);
        return (new UserController($this->request))->register();
    }

    public function login(): JsonResponse
    {
        $this->validatePosts(['email'=>'email' , 'password'=>'string']);
        return (new UserController($this->request))->login();
    }

    /**
     * Generates mock responses for API documentation
     * 
     * @param string $method The API method name
     * @return array<mixed> Example response data for the specified method
     * @hidden
     */
    public static function mockResponse(string $method): array
    {
        return match($method) {
            'register' => [
                'response_code' => 201,
                'message' => 'created',
                'count' => 1,
                'service_message' => 'user registered successfully',
                'data' => [
                    'id' => 1,
                    'email' => 'user@example.com',
                    '_accessToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...',
                    '_refreshToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'
                ]
            ],
            'login' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'login successful',
                'data' => [
                    'id' => 1,
                    'email' => 'user@example.com',
                    '_accessToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...',
                    '_refreshToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'
                ]
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
}

