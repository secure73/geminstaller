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
        //mapPost($model) is one of the most common and important method in controller layer
        //it map the incomming post data to the target object!
        //this method check all target object if can accept the data type! now you can enjoy php82+ features!
        //also you can enjoy phpstan level 9! full type support without tedius type mapping!
        $this->mapPost($model);
        return $model->createModel();
    }

    public function read(): JsonResponse
    {
        $model = new ProductModel();
        //mapPost($model) is one of the most common and important method in controller layer
        //it map the incomming post data to the target object!
        //this method check all target object if can accept the data type! now you can enjoy php82+ features!
        //also you can enjoy phpstan level 9! full type support without tedius type mapping!
        $this->mapPost($model);
        return $model->readModel();
    }

    public function update(): JsonResponse
    {
        $model = new ProductModel();
        //mapPost($model) is one of the most common and important method in controller layer
        //it map the incomming post data to the target object!
        //this method check all target object if can accept the data type! now you can enjoy php82+ features!
        //also you can enjoy phpstan level 9! full type support without tedius type mapping!
        $this->mapPost($model);
        return $model->updateModel();
    }

    public function delete(): JsonResponse
    {
        $model = new ProductModel();
        //mapPost($model) is one of the most common and important method in controller layer
        //it map the incomming post data to the target object!
        //this method check all target object if can accept the data type! now you can enjoy php82+ features!
        //also you can enjoy phpstan level 9! full type support without tedius type mapping!
        $this->mapPost($model);
        return $model->deleteModel();
    }

    public function list(): JsonResponse
    {
        $model = new ProductModel();
        //mapPost($model) is one of the most common and important method in controller layer
        //it map the incomming post data to the target object!
        //this method check all target object if can accept the data type! now you can enjoy php82+ features!
        //also you can enjoy phpstan level 9! full type support without tedius type mapping!
        return $this->createList($model);
    }
} 