<?php

namespace App\Service;

use App\Controller\LoginController;
use Gemvc\Core\Service;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Login extends Service
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

    public function accessToken(): JsonResponse
    {
        return (new LoginController($this->request))->accessToken();
    }
}
