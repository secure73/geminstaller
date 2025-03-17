<?php

namespace App\Api;

use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;
use Gemvc\Core\Documentation;

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

    public function document(): never
    {
        (new Documentation())->html();
    }
}
