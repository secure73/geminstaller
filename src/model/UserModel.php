<?php
namespace Model;

use Gemvc\Database\QueryBuilder;
use Gemvc\Helper\CryptoHelper;

use Table\UserTable;

class UserModel extends UserTable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function some()
    {
        $ss = CryptoHelper::passwordVerify("adsasdas");
        $q =QueryBuilder::insert($this->setTable())->columns('email','password')->values('ali',CryptoHelper::hashPassword('ali'));

    }
}
