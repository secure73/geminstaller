<?php

namespace App\Model;

use App\Table\UserTable;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\JWTToken;
use Gemvc\Http\Response;
use stdClass;

class UserModel extends UserTable
{
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
        
        $std = new stdClass();
        $std->user = $user;
        $std->access_token = $token->createAccessToken($user->id);
        $std->refresh_token = $token->createRefreshToken($user->id);
        return Response::success($std,1,"login successfull");
    }
}
