<?php

namespace App\Table;

use App\Core\Table;
use App\Core\Interface\ITable;
use App\Core\TableTrait\TDelete;
use App\Core\TableTrait\TInsert;
use App\Core\TableTrait\TSelect;
use App\Core\TableTrait\TUpdate;

class UserTable extends Table implements ITable
{
    use TSelect;
    use TInsert;
    use TUpdate;
    use TDelete;

    public int $id;
    public string $email;
    public string $password;
    public ?string $name;
    public string $role;

    public function __construct()
    {
        $this->name = null;
        parent::__construct();
    }

    public function getTable(): string
    {
        return 'users';
    }

    public function selectByEmail(string $email = null): bool
    {
        if ($email) {
            $this->email = $email;
        }
        $result = $this->select()->where('email', $this->email)->limit(1)->run();
        if (!$result || !is_array($result) || !isset($result[0])) {
            return false;
        }
        $found = $result[0];
        /**@phpstan-ignore-next-line */
        foreach ($found as $key => $val) {
            $this->$key = $val;
        }
        return true;
    }
}
