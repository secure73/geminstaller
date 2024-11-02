<?php

namespace App\Api;

use App\Controller\LoginController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Login extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function byEmail(): JsonResponse
    {
        return (new LoginController($this->request))->loginByEmail();
    }

    public function byToken(): JsonResponse
    {
        return (new LoginController($this->request))->loginByToken();
    }
}

