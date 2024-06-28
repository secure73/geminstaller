<?php

namespace App\Service;

use App\Controller\AuthenticateController;
use Gemvc\Core\Auth;
use Gemvc\Core\Service;
use Gemvc\Http\JWTToken;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

class Authenticate extends Service
{
    private JWTToken $jwtToken;
    public function __construct(Request $request)
    {
        $auth = new Auth($request);
        if(!$auth->success())
        {
            Response::forbidden($auth->error)->show();
            die;
        }
        $this->jwtToken = $auth->token;
        parent::__construct($request);
    }

    public function index(): JsonResponse
    {
        return Response::success($this->jwtToken,1,"token is valid");
    }

    public function verifyToken():JsonResponse
    {
        return Response::success($this->jwtToken,1,"token is valid");
    }

    public function userRoles():JsonResponse
    {
        return (new AuthenticateController($this->request))->userRoles();
    }
    
    public function createAccessToken(): JsonResponse
    {
        return (new AuthenticateController($this->request))->createAccessToken();
    }
}
