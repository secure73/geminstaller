<?php

namespace App\Model;

use Gemvc\Core\Model;
use Gemvc\Http\Request;
use App\Table\UserTable;
use Gemvc\Helper\CryptHelper;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

class RegisterModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function registerByEmail(): JsonResponse
    {
        $user = new UserTable();
        $this->mapPostManuel(["email"],$user);
        if ($user->selectByEmail()) {
            return Response::badRequest('use another email address');
        }
        /**@phpstan-ignore-next-line */
        $user->password = CryptHelper::hashPassword($this->request->post["password"]);
        $id = $user->insertSingleQuery();
        if (!$id) {
            return Response::internalError($user->getError());
        }
        $user->id = $id;
        $user->password = "";
        return Response::success($user, 1);
    }
}
