<?php
namespace App\Controller;
use App\Model\AuthenticateModel;
use App\Model\UserModel;
use Gemvc\Core\Auth;
use Gemvc\Http\Request;
use Gemvc\Core\Controller;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;


class AuthenticateController extends Controller {
    private Auth $auth;
    public function __construct(Request $request){
        $this->auth = new Auth($request);
        parent::__construct($request);
    }

    public function createAccessToken():JsonResponse
    {
        if($this->auth->token->type !== 'refresh')
        {
            return Response::unauthorized('only refresh token can perform this action');
        }
        if (!$this->validatePosts(['role_id' => 'int'])) {
            return Response::badRequest($this->error);        
        }
        return(new AuthenticateModel($this->request))->createAccessToken($this->request->post["role_id"]);
    }

    public function userRoles():JsonResponse
    {
        if($this->auth->token->type !== 'refresh')
        {
            return Response::unauthorized('only refresh token can perform this action');
        }
        if (!$this->validatePosts(['role_id' => 'int'])) {
            return Response::badRequest($this->error);        
        }
        return(new RoleModel($this->request))->userRoles($this->auth->user_id);
    }

    public function roles():JsonResponse
    {
        return (new RoleModel($this->request))->list();
    }

    public function rolePermissions():JsonResponse
    {

    }

}