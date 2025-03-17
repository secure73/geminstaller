<?php

/**
 * this is table layer. what so called Data access layer
 * classes in this layer shall be extended from CRUDTable or Gemvc\Core\Table ;
 * for each column in database table, you must define property in this class with same name and property type;
 */ 
namespace App\Table;

use Gemvc\Core\CRUDTable;
/**
 * User table class for handling user database operations
 * 
 * @property int $id User's unique identifier column id in database table   
 * @property string $email User's email address column email in database table
 * @property string $password User's hashed password column password in database table
 * @property string $role User's role (e.g., 'admin', 'user', 'company-admin', 'teacher') column role in database table
 */
class UserTable extends CRUDTable 
{
    public int $id;
    public string $email;
    public string $password;
    public string $role;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTable(): string
    {
        //return the name of the table  in database
        return 'users';
    }

    /**
     * @return null|static
     * null or UserTable Object
     */
    public function selectByEmail(): null|static
    {
        $result = $this->select()->where('email', $this->email)->limit(1)->run();
        if (count($result) !==1) {
            return null;
        }
        return  $result[0];
    }

    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        return $result[0] ?? null;
    }

        


}
