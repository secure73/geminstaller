<?php

namespace App\Model;

use App\Core\Model;
use GemLibrary\Http\Request;
use App\Table\UserTable;
use GemLibrary\Helper\CryptHelper;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Response;

class RegisterModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function registerByEmail(): JsonResponse
    {
        $user = new UserTable();
        /**@phpstan-ignore-next-line */
        $user->email = $this->request->post["email"];
        if ($user->selectByEmail()) {
            return Response::badRequest('use another email address');
        }
        /**@phpstan-ignore-next-line */
        $user->password = CryptHelper::hashPassword($this->request->post["password"]);
        $id = $user->insert();
        if (!$id) {
            return Response::internalError($user->getError());
        }
            $user->id = $id;
        $user->password = "";
        return Response::success($user, 1);
    }
}
