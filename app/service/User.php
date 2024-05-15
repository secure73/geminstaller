<?php

namespace App\Service;

use GemLibrary\Http\Request;
use GemLibrary\Http\JsonResponse;
use App\Controller\ContactController;
use App\Controller\ProfileController;
use App\Core\Service;

class User extends Service
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function createContact(): JsonResponse
    {
        return (new ContactController($this->request))->create();
    }

    public function deleteContact(): JsonResponse
    {
        return (new ContactController($this->request))->remove();
    }

    public function updateContact(): JsonResponse
    {
        return (new ContactController($this->request))->update();
    }

    public function findContact(): JsonResponse
    {
        return (new ContactController($this->request))->find();
    }

    public function listContacts(): JsonResponse
    {
        return (new ContactController($this->request))->listByUser();
    }

    public function createProfile(): JsonResponse
    {
        return (new ProfileController($this->request))->create();
    }
}
