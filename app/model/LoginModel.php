<?php

namespace App\Model;

use Gemvc\Core\Auth;
use Gemvc\Core\Model;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use App\Table\UserTable;

class LoginModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function loginByEmailAndPassword(): JsonResponse
    {
        $user = new UserTable();
        $this->mapPostManuel(["email"],$user);
        $user = $user->selectByEmail();
        if ($user===false) {
            return Response::forbidden('username or password is wrong');
        }
        /**@phpstan-ignore-next-line */
        if (!CryptHelper::passwordVerify($this->request->post['password'], $user->password)) {
            return Response::forbidden('username or password is wrong');
        }
        return UserModel::createLoginCredential($user->id);
    }

    public function loginByToken(): JsonResponse
    {
        $auth = new Auth($this->request);
        if(!isset($auth->token->type) || $auth->token->type !== 'login')
        {
            return Response::unauthorized("only token with type login can perform this action");
        }
        return UserModel::createLoginCredential($auth->token->user_id);
    }
}
