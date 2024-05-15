<?php

namespace App\Service;

use App\Controller\RegisterController;
use App\Core\Service;
use GemLibrary\Http\Request;
use GemLibrary\Http\JsonResponse;

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
