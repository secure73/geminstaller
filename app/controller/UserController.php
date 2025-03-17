<?php

namespace App\Controller;

use App\Model\UserModel;
use Gemvc\Core\Controller;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function userList(): JsonResponse
    {
        $model = new UserModel();
        // there is way how to create list with filterable, sortable, findable
        //no need at all to have list method in model
        return $this->createList($model);
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

    public function updateRole(): JsonResponse
    {
        $model = new UserModel();
        $this->mapPost($model);
        return $model->updateRole();
    }

    public function updatePassword(): JsonResponse
    {
        $model = new UserModel();
        $this->mapPost($model);
        return $model->updatePassword();
    }
}
