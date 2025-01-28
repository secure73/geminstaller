<?php

namespace App\Api;

use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

class Index extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(): JsonResponse
    {
        $this->validatePosts([]);
        return Response::success("gemvc is successfully installed");
    }
}
