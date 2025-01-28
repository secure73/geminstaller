<?php

namespace App\Api;

use App\Controller\UserController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class User extends ApiService
{
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
}

