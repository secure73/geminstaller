<?php

namespace App\Api;

use App\Controller\IndexController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Index extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(): JsonResponse
    {
        return (new IndexController($this->request))->index();
    }
}
