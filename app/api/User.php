<?php
/**
 * this is service layer. what so called url end point
 * this layer shall be extended from ApiService class
 * this layer is responsible for handling the request and response
 * this layer is responsible for handling the authentication
 * this layer is responsible for handling the authorization
 * this layer is responsible for handling the validation
 */
namespace App\Api;

use App\Controller\UserController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;
use Gemvc\Core\Auth;
use Gemvc\Http\Response;
/**
 * User Service Class
 * Handles user-related API endpoints including registration and authentication.
 * Extends ApiService for base API functionality.
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
        //validate the post data is one of the most important part in GEMVC framework
        //this method firstof all sanitize  and then validate the data
        //also by using this method you have full auto complete Documentations !
        //this method is essntial to validate the data before sending it to the model layer and it is very easy to use
        //also it return proper failure messages and response codes to front end developer!
        $this->validatePosts(['email'=>'email' , 'password'=>'string']);
        return (new UserController($this->request))->register();
    }

    public function login(): JsonResponse
    {
        //validate the post data is one of the most important part in GEMVC framework
        //this method firstof all sanitize  and then validate the data
        //also by using this method you have full auto complete Documentations !
        //this method is essntial to validate the data before sending it to the model layer and it is very easy to use
        //also it return proper failure messages and response codes to front end developer!
        $this->validatePosts(['email'=>'email' , 'password'=>'string']);
        return (new UserController($this->request))->login();
    }

    public function updatePassword(): JsonResponse
    {
        //in this way only authenticated user can update his password
        $auth = new Auth($this->request);
        //password type of string and min length 6 and max length 15
        $this->validateStringPosts(['password'=>'6|15']);
        //check if the user in tokenhas id
        if(!$auth->token ||!$auth->token->user_id){
            return Response::forbidden("you are not authorized to access this resource");
        }
        //set the id to the authenticated user id, in this way authenticated user can update only his own password
        $this->request->post['id'] = $auth->token->user_id;
        
        return (new UserController($this->request))->updatePassword();
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
            'updatePassword' => [
                'response_code' => 200,
                'message' => 'OK',
                'count' => 1,
                'service_message' => 'Password updated successfully',
                'data' => [
                    'id' => 1,
                    'email' => 'user@example.com'
                ]
            ],
            default => [
                'success' => false,
                'message' => 'Unknown method'
            ]
        };
    }
}

