<?php

namespace App\Model;

use Gemvc\Core\Model;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JWTToken;
use App\Table\UserTable;
use stdClass;

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
        if (!$user->selectByEmail()) {
            return Response::unauthorized('username or password is wrong');
        }
        /**@phpstan-ignore-next-line */
        if (!CryptHelper::passwordVerify($this->request->post['password'], $user->password)) {
            return Response::unauthorized();
        }
        return UserModel::createLoginCredential($user->id);
    }

    public function loginByToken(): JsonResponse
    {
        $token = $this->verifyRefreshToken();
        if (!$token) {
            return Response::forbidden();
        }
        return UserModel::createLoginCredential($token->user_id);
    }

    public function accessToken(): JsonResponse
    {
        $token = $this->verifyRefreshToken();
        if (!$token) {
            return Response::forbidden();
        }
        $std = new stdClass();
        $std->accessToken = $token->createAccessToken($token->user_id);
        return Response::success($std);
    }

    private function verifyRefreshToken(): false|JWTToken
    {
        $token = new JWTToken();
        if(!$token->extractToken($this->request))
        {
            Response::forbidden($token->error);
            return false;
        }
        if (!$token->verify()) {
            Response::forbidden($token->error);
            return false;
        }
        if ($token->type !== 'refresh') {
            Response::unauthorized('only refresh Token can perform login');
            return false;
        }
        return $token;
    }
}
