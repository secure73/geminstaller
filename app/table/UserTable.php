<?php

namespace App\Table;

use Gemvc\Core\Table;
use Gemvc\Traits\Table\InsertSingleQueryTrait;
use Gemvc\Traits\Table\UpdateQueryTrait;
class UserTable extends Table 
{
    use InsertSingleQueryTrait;
    use UpdateQueryTrait;
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

    public function selectByEmail(string $email = null): false|UserTable
    {
        if ($email) {
            $this->email = $email;
        }
        $result = $this->select()->where('email', $this->email)->limit(1)->run();
        if (!$result || count($result) !==1) {
            return false;
        }
        return  $result[0];
    }

    public function selectById(int $id): bool|UserTable
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        if (!$result || count($result) !== 1) {
            return false;
        }
        return $result[0];
    }
}
