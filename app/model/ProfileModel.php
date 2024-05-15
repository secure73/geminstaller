<?php

namespace App\Model;

use App\Core\Model;
use App\Table\ProfileTable;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;

class ProfileModel extends Model
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function save(): JsonResponse
    {
        $profile = new ProfileTable();
/**@phpstan-ignore-next-line */
        $profile->id = $this->request->token->user_id;
/**@phpstan-ignore-next-line */
        $profile->name = $this->request->post['name'];
        $profile->insert();
        if ($profile->getError()) {
            return Response::internalError($profile->getError());
        }
        return Response::success($profile, 1);
    }
}
