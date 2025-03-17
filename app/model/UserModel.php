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

    public function updateRole(): JsonResponse
    {
        $user = $this->selectById($this->id);
        if(!$user){
            return Response::notFound("user not found");
        }
        $user->role = $this->role;
        $user->update("id",$this->id);
        return Response::success($user,1,"role updated successfully");
    }   

    public function updatePassword(): JsonResponse
    {
        $found = $this->selectById($this->id);
        if(!$found){
            return Response::notFound("user not found");
        }
        $found->password = CryptHelper::hashPassword($this->password);
        $found->update("id",$this->id);
        $found->password = "-";
        return Response::success($found,1,"password updated successfully");
    }

    private function createTokens(UserModel $user): JsonResponse
    {
        $token = new JWTToken();
        $token->role = $user->role;
        $user->password = "-";
        $this->_accessToken = $token->createAccessToken($user->id);
        $this->_refreshToken = $token->createRefreshToken($user->id);
        return Response::success($user,1,"login successfull");
    }
}
