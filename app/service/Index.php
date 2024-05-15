<?php

namespace App\Service;

use App\Core\Service;
use GemLibrary\Http\Request;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Response;

class Index extends Service
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(): JsonResponse
    {
        return Response::success('welcome to Gemvc app');
    }
}
