<?php

namespace App\Api;

use App\Controller\RegisterController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Register extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function byEmail(): JsonResponse
    {
        return (new RegisterController($this->request))->registerByEmailAndPassword();
    }
}
