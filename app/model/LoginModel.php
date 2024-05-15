<?php

namespace App\Model;

use App\Core\Model;
use GemLibrary\Helper\CryptHelper;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;
use App\Table\UserTable;
use GemLibrary\Http\JWTToken;
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
/**@phpstan-ignore-next-line */
        $user->email = $this->request->post['email'];
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
