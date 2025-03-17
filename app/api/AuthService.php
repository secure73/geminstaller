<?php
/**
 * this is service layer. what so called url end point
 * this layer shall be extended from ApiService class
 * this layer is responsible for handling the request and response
 * this layer is responsible for handling the authentication
 * this layer is responsible for handling the authorization
 * this layer is responsible for handling the validation
 */
namespace App\Api;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Core\Auth;
use Gemvc\Http\Response;

/**
 * Base authentication service
 * @hidden
 */
class AuthService extends ApiService
{

    protected Auth $auth;
    protected int $user_id;

    protected ?string $role;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->role = "";
        $this->auth = new Auth($request);
        if (!$this->auth->token) {
            Response::forbidden('token not found')->show();
            die();
        }

        if (!$this->auth->token->user_id) {
            Response::forbidden('unknown user')->show();
            die();
        }
        $this->user_id = $this->auth->token->user_id;
        $this->role = $this->auth->token->role;
    }

}
