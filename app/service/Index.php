<?php

namespace App\Service;

use App\Controller\IndexController;
use Gemvc\Core\Service;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class Index extends Service
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
