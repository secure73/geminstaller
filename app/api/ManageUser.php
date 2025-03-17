<?php

namespace App\Api;

use App\Controller\UserController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JsonResponse;


class ManageUser extends AuthService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if($this->role !== "admin"){
            Response::forbidden("you are not authorized to access this resource")->show();
            die();
        }
    }

    public function updateRole(): JsonResponse
    {
        $this->validatePosts(['id'=>'int','role'=>'string']);
        return (new UserController($this->request))->updateRole();
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
        return match($method){
            'updateRole' => [
                'response_code' => 200,
                'message' => 'updated',
                'count' => 1,
                'service_message' => 'role updated successfully',
                'data' => [
                    'id' => 1,
                    'role' => 'admin',
                ]
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
    
}
