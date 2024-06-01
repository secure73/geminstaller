<?php

namespace App\Controller;

use App\Model\RegisterModel;
use Gemvc\Core\Controller;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JsonResponse;

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
