<?php

namespace App\Controller;

use Gemvc\Core\Controller;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Request;
use App\Model\ProductModel;


class ProductController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function create(): JsonResponse
    {
        $model = new ProductModel();
        $this->mapPost($model);
        return $model->createModel();
    }

    public function read(): JsonResponse
    {
        $model = new ProductModel();
        $this->mapPost($model);
        return $model->readModel();
    }

    public function update(): JsonResponse
    {
        $model = new ProductModel();
        $this->mapPost($model);
        return $model->updateModel();
    }

    public function delete(): JsonResponse
    {
        $model = new ProductModel();
        $this->mapPost($model);
        return $model->deleteModel();
    }

    public function list(): JsonResponse
    {
        $model = new ProductModel();
        return $this->createList($model);
    }
} 