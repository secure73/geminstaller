<?php

namespace App\Model;

use App\Core\Model;
use App\Table\UserTable;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\JWTToken;
use GemLibrary\Http\Request;
use stdClass;

class UserModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public static function createLoginCredential(int $id): JsonResponse
    {

        $user = new UserTable();
        $user->selectById($id);
        $user->password = "";

        $token = new JWTToken();
        $token->role = $user->role;
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
