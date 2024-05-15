<?php

namespace App\Model;

use App\Core\Model;
use App\Table\ContactTable;
use GemLibrary\Http\JsonResponse;
use GemLibrary\Http\Request;
use GemLibrary\Http\Response;
use App\Core\Auth;

class ContactModel extends Model
{
    private Auth $auth;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->auth = new Auth($request);
        if(!$this->auth->success())
        {
            Response::forbidden($this->auth->error)->show();
            die;
        }
        $this->auth = new Auth($request);
    }

    public function create(): JsonResponse
    {
        $contact = new ContactTable();
        if (!$this->mapPost($contact)) {
            return Response::unprocessableEntity($this->error);
        }
        $contact->user_id = $this->auth->user_id;
        $result = $contact->insert();
        if (!$result) {
            return Response::internalError($contact->getError());
        }
        return Response::created($contact, 1);
    }

    public function update(): JsonResponse
    {
        $contact = $this->getContact();
        if(!$contact)
        {
            return Response::notFound('no contact found with given id');
        }
        if(!$this->isContactBelongToCurrentUser($contact))
        {
            return Response::unauthorized();
        }
        $this->mapPost($contact);
        $result = $contact->update();
        if (!$result) {
            return Response::internalError($contact->getError());
        }
        return Response::updated($contact, 1);
    }

    public function remove(): JsonResponse
    {

        $contact = $this->getContact();
        if(!$contact)
        {
            return Response::notFound('no contact found with given id');
        }
        if(!$this->isContactBelongToCurrentUser($contact))
        {
            return Response::unauthorized();
        }
        if (!$contact->delete()) {
            return Response::internalError($contact->getError());
        }
        return Response::deleted($contact, 1, 'deleted successfully');
    }

    public function find(): JsonResponse
    {
        $contact = new ContactTable();
        $this->mapPost($contact);
        $contact->user_id = $this->auth->user_id;
        $result = $contact->selectLikeByName();

        if (!is_array($result)) {
            return Response::internalError($contact->getError());
        }
        return Response::success($result, $contact->getTotalCounts());
    }

    public function listByUser(): JsonResponse
    {
        $contact = new ContactTable();
        $contact->user_id = $this->auth->user_id;
        $result = $contact->selectAllByUser();
        if (!is_array($result)) {
            return Response::internalError($contact->getError());
        }
        return Response::success($result, $contact->getTotalCounts());
    }

    private function getContact():false|ContactTable
    {
        $check = new ContactTable();
        $this->mapPost($check);
        if (!$check->selectById()) {
            $this->error = "contact with given id doesn't exists";
            return false;
        }
        return $check;
    }

    private function isContactBelongToCurrentUser(ContactTable $contact):bool
    {
        if ($contact->user_id !== $this->auth->user_id) {
            $this->error = 'you are not authorized to perform this action';
            return false;
        }
        return true;
    }
}
