<?php

namespace App\Controller;

use App\Core\Controller;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;
use App\Model\ProfileModel;

class ProfileController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function create(): JsonResponse
    {
        if (!$this->validatePosts(['id' => 'int','name' => 'string','?tel' => 'string','?address' => 'string'])) {
            return Response::badRequest($this->error);
        }
        return (new ProfileModel($this->request))->save();
    }
}
