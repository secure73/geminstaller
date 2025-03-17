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
use Gemvc\Http\Response;
use Gemvc\Http\JsonResponse;


class ManageUser extends AuthService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //only valid token with admin role can access this resource
        if($this->role !== "admin"){
            Response::forbidden("you are not authorized to access this resource")->show();
            die();
        }
    }

    public function userList(): JsonResponse
    {
        //filterable is for filter by id, role, email example: /api/userList/?filter_byemail=admin@example.com
        $this->request->filterable(['id'=>'int','role'=>'string','email'=>'email']);
        //sortable is for sort by id, role, email example: /api/userList/?sort_by_asc=id  or /api/userList/?sort_by=id
        $this->request->sortable(['id'=>'int','role'=>'string','email'=>'string']);
        //findable is for search by email like %email% example: /api/userList/?find_like=email=john@exam
        $this->request->findable(['email'=>'email']);
        return (new UserController($this->request))->userList();
    }

    public function updateRole(): JsonResponse
    {
        //validate the post data is one of the most important part in GEMVC framework
        //this method firstof all sanitize  and then validate the data
        //also by using this method you have full auto complete Documentations !
        //this method is essntial to validate the data before sending it to the model and it is very easy to use
        //also it return proper failure messages and response codes to front end developer!
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
