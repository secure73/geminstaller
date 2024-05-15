<?php

namespace App\Controller;

use App\Core\Controller;
use GemLibrary\Http\Request;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Response;
use App\Model\ContactModel;

class ContactController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function create(): JsonResponse
    {
        if (!$this->validatePosts(['name' => 'string','?tel' => 'string','?email' => 'email'])) {
            return Response::badRequest($this->error);
        }
        return (new ContactModel($this->request))->create();
    }

    public function update(): JsonResponse
    {
        if (!$this->validatePosts(['id' => 'int','?name' => 'string','?tel' => 'string','?email' => 'email','?address' => 'string'])) {
            return Response::badRequest($this->error);
        }
        return (new ContactModel($this->request))->update();
    }

    public function remove(): JsonResponse
    {
        if (!$this->validatePosts(['id' => 'int'])) {
            return Response::badRequest($this->error);
        }
        return (new ContactModel($this->request))->remove();
    }

    public function find(): JsonResponse
    {
        if (!$this->validatePosts(['name' => 'string'])) {
            return Response::badRequest($this->error);
        }
        return (new ContactModel($this->request))->find();
    }

    public function listByUser(): JsonResponse
    {
        return (new ContactModel($this->request))->listByUser();
    }
}
