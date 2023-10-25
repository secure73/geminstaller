<?php
namespace Table;

use GemFramework\Core\BaseTable;

class UserTable extends BaseTable{
    
    public int $id;
    public string $email;
    public string $password;
    
    public function __construct()
    {
        parent::__construct();
    }
    public function setTable(): string
    {
        return 'users';
    }




}