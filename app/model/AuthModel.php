<?php

namespace App\Model;

use Gemvc\Core\Auth;
use Gemvc\Core\Model;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JWTToken;
use App\Table\UserTable;
use stdClass;

class AuthenticateModel extends Model
{
    private int $user_id;
    public function __construct(Request $request)
    {
        $auth = new Auth($request);
        $this->user_id = $auth->user_id;
        parent::__construct($request);
    }

    public function createAccessToken(int $role_id_to_apply): JsonResponse
    {
        //logic to create access token for a user for exact role
        
        //result can be success of unauthorize depends on role
        if(false){
            return Response::unauthorized('you are now allowed to apply for this role');
        }

        return Response::success("");
    }



}
