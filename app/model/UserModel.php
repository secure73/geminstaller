<?php

namespace App\Model;

use App\Table\UserTable;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\JWTToken;
use Gemvc\Http\Response;

class UserModel extends UserTable
{
    public string $_accessToken;
    public string $_refreshToken;
    public function __construct()
    {
        parent::__construct();
    }

    public function register(): JsonResponse
    {
        $found = $this->selectByEmail();
        if ($found) {
            return Response::notAcceptable("email is not accepteble");
        }
        $this->password = CryptHelper::hashPassword($this->password);
        $success = $this->insert();
        return $this->createTokens($success);
    }

    public function login(): JsonResponse
    {
        $success = $this->selectByEmail();
        if (!$success) {
            return Response::forbidden("no user registered");
        }
        if(!CryptHelper::passwordVerify($success->password, $this->password)){
            return Response::forbidden("username or password is wrong");
        } 
        return $this->createTokens($success);
    }

    private function createTokens(UserModel $user): JsonResponse
    {
        $token = new JWTToken();
        $token->role = "user";
        $user->password = "-";
        $this->_accessToken = $token->createAccessToken($user->id);
        $this->_refreshToken = $token->createRefreshToken($user->id);
        return Response::success($user,1,"login successfull");
    }
}
