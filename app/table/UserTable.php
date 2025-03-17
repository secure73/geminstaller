<?php

namespace App\Table;

use Gemvc\Core\CRUDTable;
/**
 * User table class for handling user database operations
 * 
 * @property int $id User's unique identifier
 * @property string $email User's email address
 * @property string $password User's hashed password
 * @property string $role User's role (e.g., 'admin', 'user', 'company-admin', 'teacher')
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
