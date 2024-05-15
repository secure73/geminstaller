<?php

namespace App\Controller;

use App\Core\Controller;
use GemLibrary\Http\Request;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
