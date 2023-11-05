<?php
namespace App\Model;
use App\Table\UserTable;
use GemLibrary\Helper\CryptHelper;

class UserModel extends UserTable{
    public function __construct()
    {
        parent::__construct();
    }

    public function create():int|null
    {
        $this->password = CryptHelper::hashPassword($this->password);
        return $this->insert();
    }
}
