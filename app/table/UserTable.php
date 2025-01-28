<?php

namespace App\Table;

use Gemvc\Core\CRUDTable;
class UserTable extends CRUDTable 
{
    public int $id;
    public string $email;
    public string $password;

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

    /**
     * Summary of selectById
     * @param int $id
     * @return static|null
     */
    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        if (count($result) !== 1) {
            return null;
        }
        return $result[0];
    }
}
