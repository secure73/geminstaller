<?php

namespace App\Controller;

use App\Model\UserModel;
use Gemvc\Core\Controller;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function register(): JsonResponse
    {
        $model = new UserModel();
        $this->mapPost($model);
        return $model->register();
    }

    public function login(): JsonResponse
    {
        $model = new UserModel();
        $this->mapPost($model);
        return $model->login();
    }
}
