<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\RegisterModel;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;
use GemLibrary\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function registerByEmailAndPassword(): JsonResponse
    {
        if (!$this->validatePosts(['email' => 'email', 'password' => 'string'])) {
            return Response::badRequest($this->error);
        }
        return (new RegisterModel($this->request))->registerByEmail();
    }
}
