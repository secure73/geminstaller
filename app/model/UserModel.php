<?php

namespace App\Model;

use App\Table\UserTable;
use Gemvc\Core\Model;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\JWTToken;
use Gemvc\Http\Request;
use stdClass;

class UserModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public static function createLoginCredential(int $id): JsonResponse
    {

        $user = (new UserTable())->selectById($id);
        $user->password = "";

        $token = new JWTToken();
        #you can create role model with its relevant table to set token Role!
        $token->role = "";
        $refreshToken = $token->createRefreshToken($id);
        $accessToken = $token->createAccessToken($id);

        $std = new stdClass();
        $std->user = $user;
        $std->refreshToken = $refreshToken;
        $std->accessToken = $accessToken;

        $response = new JsonResponse();
        return $response->success($std, 1);
    }
}
