<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\LoginModel;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;
use GemLibrary\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function loginByEmail(): JsonResponse
    {
        if (!$this->validatePosts(['email' => 'email','password' => 'string'])) {
            return Response::badRequest($this->error);        
        }
        return (new LoginModel($this->request))->loginByEmailAndPassword();
    }

    public function loginByToken(): JsonResponse
    {
        $this->request->post = [];
        return (new LoginModel($this->request))->loginByToken();
    }

    public function accessToken(): JsonResponse
    {
        $this->request->post = [];
        return (new LoginModel($this->request))->accessToken();
    }
}
