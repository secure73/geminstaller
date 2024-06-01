<?php

namespace App\Service;

use App\Controller\RegisterController;
use Gemvc\Core\Service;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Register extends Service
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
